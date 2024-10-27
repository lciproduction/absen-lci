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

        $absenLat = $request->latitude ?? NULL;
        $absenLng = $request->longitude ?? NULL;
        $distance = $this->haversine($centerLat, $centerLng, $absenLat, $absenLng);

        $waktuAbsen = Time::first();
        if (!$waktuAbsen) {
            return response()->json(['message' => 'Waktu absen tidak ditemukan']);
        }

        $timeInEarly = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_early);
        $timeInLate = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_in_lately);
        $timeOutEarly = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_early);
        $timeOutLate = Carbon::createFromFormat('H:i:s', $waktuAbsen->time_out_lately);
        Log::info('Status dari request:', ['status' => $timeOutEarly]);


        // Pengecekan absensi masuk hari ini
        $existingAttendanceMasuk = Attendance::where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Absen Masuk WFO', 'Absen Masuk WFH', 'Absen Masuk WFO (terlambat)', 'Absen Masuk WFH (terlambat)', 'Izin', 'Sakit'])
            ->first();

        $status = '';
        $message = '';

        switch ($request->status) {
            case 'HadirWFO':
                if ($existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
                }

                // Absen Masuk WFO
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    if ($distance > $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Masuk WFO';
                    $message = 'Absen Masuk WFO Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFO (Terlambat)';
                    $message = 'Absen Masuk Berhasil, terlambat ' . $lateMinutes . ' menit';
                    $student->point -= 2;
                    $student->save();
                }
                break;

            case 'HadirWFH':
                if ($existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
                }

                // Absen Masuk WFH
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    $status = 'Absen Masuk WFH';
                    $message = 'Absen Masuk WFH Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFH (Terlambat)';
                    $message = 'Absen Masuk Berhasil, terlambat ' . $lateMinutes . ' menit';
                    $student->point -= 2;
                    $student->save();
                }
                break;

            case 'PulangWFO':
                if (!$existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda belum melakukan absen masuk hari ini']);
                }

                // Pengecekan jika sudah ada absen pulang
                $existingAttendancePulang = Attendance::where('student_id', $student->id)
                    ->whereDate('created_at', $today)
                    ->whereIn('status', ['Absen Pulang WFO', 'Absen Pulang WFO (Terlambat)'])
                    ->first();

                if ($existingAttendancePulang) {
                    return response()->json(['message' => 'Anda sudah melakukan absen pulang hari ini']);
                }

                // Logika Absen Pulang WFO
                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    if ($distance > $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Pulang WFO';
                    $message = 'Absen Pulang WFO Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $status = 'Absen Pulang WFO (Terlambat)';
                    $message = 'Absen Pulang WFO berhasil terlambat ' . $lateMinutes . ' menit';
                }
                break;

            case 'PulangWFH':
                if (!$existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda belum melakukan absen masuk hari ini']);
                }

                // Pengecekan jika sudah ada absen pulang
                $existingAttendancePulang = Attendance::where('student_id', $student->id)
                    ->whereDate('created_at', $today)
                    ->whereIn('status', ['Absen Pulang WFH', 'Absen Pulang WFH (Terlambat)'])
                    ->first();

                if ($existingAttendancePulang) {
                    return response()->json(['message' => 'Anda sudah melakukan absen pulang hari ini']);
                }

                // Logika Absen Pulang WFH
                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    $status = 'Absen Pulang WFH';
                    $message = 'Absen Pulang WFH Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $status = 'Absen Pulang WFH (Terlambat)';
                    $message = 'Absen Pulang WFH berhasil terlambat ' . $lateMinutes . ' menit';
                }
                break;

            case 'Izin':
                $request->validate(['izin' => 'required|string|max:100']);
                $status = 'Izin';
                $message = 'Absen Izin Berhasil Dilakukan!';
                break;

            case 'Sakit':
                $request->validate(['file' => 'required|image|mimes:jpg,jpeg,png|max:4096']);
                $filename = time() . '.png';
                $path = $request->file('file')->storeAs('attendance/' . $student->name . '/', $filename);
                $status = 'Sakit';
                $message = 'Absen Sakit Berhasil Dilakukan';
                break;

            default:
                return response()->json(['message' => 'Status tidak valid']);
        }

        Attendance::create([
            'student_id' => $student->id,
            'coordinate' => $request->status === 'HadirWFH' || $request->status === 'PulangWFH' ? null : $absenLat . ',' . $absenLng,
            'status' => $status,
            'note' => $request->status === 'Izin' ? $request->izin : ($request->status === 'Sakit' ? $filename : null),
            'day_id' => $today->dayOfWeekIso,
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
