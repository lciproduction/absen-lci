<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Time;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('student.attendance.index');
    }

    public function store(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $coord = Setting::first();
        $parts = explode(',', $coord->coordinate);
        $centerLat = (float) trim($parts[0]);
        $centerLng = (float) trim($parts[1]);
        $radius = 2; // radius dalam kilometer
        $today = Carbon::today();
        $currentTime = Carbon::now();
        $note = null;


        // Log::info($request->all());
        // dd($request->id);

        // Validasi: Absensi hanya boleh dilakukan pada hari Senin-Jumat
        // $dayOfWeek = $currentTime->dayOfWeek;
        // if ($dayOfWeek === 0 || $dayOfWeek === 6) {
        //     return response()->json(['message' => 'Sekarang Hari Libur, Selamat Beristirahat❤️']);
        // }

        $absenLat = $request->latitude ?? NULL;
        $absenLng = $request->longitude ?? NULL;
        $distance = $this->haversine($centerLat, $centerLng, $absenLat, $absenLng);

        $waktuAbsen = Time::first();
        if (!$waktuAbsen) {
            return response()->json(['message' => 'Waktu absen tidak ditemukan']);
        }
        Log::info($request->all());

        $timeInEarly = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_early);
        $timeInLate = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_lately);
        $timeOutEarly = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_early);
        $timeOutLate = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_lately);

        $existingAttendanceMasuk = Attendance::where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->where(function ($query) {
                $query->whereIn('status', ['Absen Masuk', 'Izin', 'Sakit'])
                    ->orWhere('status', 'like', '%(Masuk Terlambat)%'); // Mencari status yang mengandung "Terlambat"
            })
            ->first();


        $status = '';
        $message = '';

        Log::info($request->all());

        // Proses absensi user lain berdasarkan status
        switch ($request->status) {
            case 'sendHadir':
                if ($existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
                }
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Masuk';
                    $message = 'Absen Masuk Berhasil';
                } else {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Masuk (Masuk Terlambat)' . $formattedLate;
                    $message = 'Absen Masuk Berhasil, Terlambat ' . $formattedLate . ' jam';
                    $student->save();
                }
                break;



            case 'sendPulang':
                if (!$existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda belum melakukan absen masuk hari ini']);
                }

                $existingAttendancePulang = Attendance::where('student_id', $student->id)
                    ->whereDate('created_at', $today)
                    ->whereIn('status', 'Absen Pulang')
                    ->orWhere('status', 'like', '%(Pulang Terlambat)%')
                    ->first();

                if ($existingAttendancePulang) {
                    return response()->json(['message' => 'Anda sudah melakukan absen pulang hari ini']);
                }

                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Pulang';
                    $message = 'Absen Pulang Berhasil';
                } else {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Pulang (Pulang Terlambat)' . $formattedLate;
                    $message = 'Absen Pulang Berhasil, Terlambat ' . $formattedLate . ' jam';
                }
                break;


            case 'Izin':
                Log::info('masuk ke case izin');
                $request->validate([
                    'izin' => 'required|string|max:255', // Keterangan izin harus ada
                ]);
                $status = 'Izin';
                $message = 'Absen Izin Berhasil';
                $note = $request->izin;
                break;
            case 'Sakit':
                $request->validate([
                    'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file
                ]);
                $status = 'Sakit';
                $message = 'Absen Sakit Berhasil';
                $filePath = $request->file('file')->store('uploads/surat_dokter', 'public');
                $note = $filePath;
                break;

            default:
                return response()->json(['message' => 'Status tidak valid']);
        }

        Attendance::create([
            'student_id' => $student->id,
            'coordinate' => ($request->status === 'sendHadir' || $request->status === 'sendPulang') ? ($absenLat . ',' . $absenLng) : null,
            'status' => $status,
            'day_id' => $today->dayOfWeekIso,
            'note' => $note
        ]);

        return response()->json(['message' => $message]);
    }


    private function haversine($centerLat, $centerLng, $absenLat, $absenLng)
    {
        $earthRadius = 6371;
        $deltaLat = deg2rad($absenLat - $centerLat);
        $deltaLng = deg2rad($absenLng - $centerLng);
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos(deg2rad($centerLat)) * cos(deg2rad($absenLat)) *
            sin($deltaLng / 2) * sin($deltaLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
