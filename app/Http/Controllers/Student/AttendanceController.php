<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Time;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Schedule;
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
        Log::info('Status dari request:', ['status' => $request->status]);

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

        $status = '';
        $message = '';

        // Validasi absensi masuk atau keluar
        $existingAttendanceMasuk = Attendance::where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Absen Masuk WFO', 'Absen Masuk WFH',])
            ->first();
        $existingAttendancePulang = Attendance::where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Absen Pulang WFO', 'Absen Pulang WFH'])
            ->first();

        Log::info('existingAttendanceMasuk:', ['status' => $existingAttendanceMasuk]);


        if ($request->status === 'HadirWFO') {
            if (!$existingAttendanceMasuk) {
                // Absen Masuk WFO
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    if ($distance > $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Masuk WFO';
                    $message = 'Absen Masuk WFO Berhasil';
                } elseif ($currentTime->gt($timeInLate)) {
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFO (Terlambat)';
                    $message = 'Absen Masuk Berhasil, terlambat ' . $lateMinutes . ' menit';
                    $student->point -= 2;
                    $student->save();
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'coordinate' => $absenLat . ',' . $absenLng,
                    'status' => $status,
                    'day_id' => $today->dayOfWeekIso,
                ]);
                return response()->json(['message' => $message]);
            } else if (!$existingAttendancePulang) {
                // Absen Pulang WFO
                if (!$existingAttendanceMasuk) {
                    // Jika belum absen masuk, catat absen masuk terlambat
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFO (Terlambat)';
                    Attendance::create([
                        'student_id' => $student->id,
                        'coordinate' => $absenLat . ',' . $absenLng,
                        'status' => $status,
                        'day_id' => $today->dayOfWeekIso,
                    ]);
                    $student->point -= 2;
                    $student->save();
                }

                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    if ($distance > $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Pulang WFO';
                    $message = 'Absen Pulang WFO Berhasil';
                } elseif ($currentTime->gt($timeOutLate)) {
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $status = 'Absen Pulang WFO (Terlambat)';
                    $message = 'Absen Pulang WFO berhasil terlambat ' . $lateMinutes . ' menit';
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'coordinate' => $absenLat . ',' . $absenLng,
                    'status' => $status,
                    'day_id' => $today->dayOfWeekIso,
                ]);
                return response()->json(['message' => $message]);
            }
        } elseif ($request->status === 'HadirWFH') {
            if (!$existingAttendanceMasuk) {
                // Absen Masuk WFH
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    $status = 'Absen Masuk WFH';
                    $message = 'Absen Masuk WFH Berhasil';
                } elseif ($currentTime->gt($timeInLate)) {
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFH';
                    $message = 'Absen Masuk Berhasil, terlambat ' . $lateMinutes . ' menit'
                        . $existingAttendanceMasuk;
                    $student->point -= 2;
                    $student->save();
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'coordinate' => null,
                    'status' => $status,
                    'day_id' => $today->dayOfWeekIso,
                ]);
                return response()->json(['message' => $message]);
            } else if (!$existingAttendancePulang) {
                // Absen Pulang WFH
                if (!$existingAttendanceMasuk) {
                    // Jika belum absen masuk, catat absen masuk terlambat
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $status = 'Absen Masuk WFH';
                    Attendance::create([
                        'student_id' => $student->id,
                        'coordinate' => null,
                        'status' => $status,
                        'day_id' => $today->dayOfWeekIso,
                    ]);
                    $student->point -= 2;
                    $student->save();
                }

                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    $status = 'Absen Pulang WFH';
                    $message = 'Absen Pulang WFH Berhasil';
                } elseif ($currentTime->gt($timeOutLate)) {
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $status = 'Absen Pulang WFH';
                    $message = 'Absen Pulang WFH berhasil terlambat ' . $lateMinutes . ' menit';
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'coordinate' => null,
                    'status' => $status,
                    'day_id' => $today->dayOfWeekIso,
                ]);
                return response()->json(['message' => $message]);
            }
        }

        // Izin dan Sakit, gunakan logika sesuai kebutuhan izin dan sakit
        if ($request->status === 'Izin') {
            $request->validate(['izin' => 'required|string|max:100']);
            Attendance::create([
                'student_id' => $student->id,
                'coordinate' => null,
                'status' => 'Izin',
                'note' => $request->izin,
                'day_id' => $today->dayOfWeekIso,
            ]);
            return response()->json(['message' => 'Absen Izin Berhasil Dilakukan!']);
        } elseif ($request->status === 'Sakit') {
            $request->validate(['file' => 'required|image|mimes:jpg,jpeg,png|max:4096']);
            $filename = time() . '.png';
            $path = $request->file('file')->storeAs('attendance/' . $student->name . '/', $filename);

            Attendance::create([
                'student_id' => $student->id,
                'coordinate' => null,
                'status' => 'Sakit',
                'note' => $filename,
                'day_id' => $today->dayOfWeekIso,
            ]);
            return response()->json(['message' => 'Absen Sakit Berhasil Dilakukan']);
        }

        return response()->json(['message' => 'Anda sudah melakukan absen hari ini']);
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
        $distance = $earthRadius * $c;

        return $distance;
    }
}
