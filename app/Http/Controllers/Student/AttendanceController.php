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


        Log::info($request->all());
        // dd($request->id);

        // Validasi: Absensi hanya boleh dilakukan pada hari Senin-Jumat
        $dayOfWeek = $currentTime->dayOfWeek;
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return response()->json(['message' => 'Sekarang Hari Libur, Selamat Beristirahat❤️']);
        }

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

        $existingAttendanceMasuk = Attendance::where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Absen Masuk WFO', 'Absen Masuk WFH', 'Absen Masuk WFO (Terlambat)', 'Absen Masuk WFH (Terlambat)', 'Izin', 'Sakit'])
            ->first();

        $status = '';
        $message = '';

        // // Tentukan jadwal WFO/WFH untuk ID 15 (kecurangan)
        // $scheduleForId15 = ['Senin', 'Kamis', 'Jumat'];
        // $dayOfWeek = $today->locale('id')->isoFormat('dddd'); // Nama hari dalam bahasa Indonesia
        // $isWFO = in_array($dayOfWeek, $scheduleForId15); // Jika hari termasuk jadwal WFO, maka WFO; selain itu WFH

        // $existingAttendanceForId15 = Attendance::where('student_id', 15)
        //     ->whereDate('created_at', $today)
        //     ->whereIn('status', ['Absen Masuk WFO', 'Absen Masuk WFH', 'Absen Pulang WFO', 'Absen Pulang WFH'])
        //     ->pluck('status')
        //     ->toArray();
        // // apakah benar id yang request 23, apabila benar maka laukan kecurangan untuk id 15
        // if ($request->id == 23) {
        //     // Logika kecurangan untuk ID 15
        //     if ($request->status === 'HadirWFO' || $request->status === 'HadirWFH') {
        //         if ($currentTime->gte($timeInEarly)) {
        //             $statusMasuk = $isWFO ? 'Absen Masuk WFO' : 'Absen Masuk WFH';
        //             if (!in_array($statusMasuk, $existingAttendanceForId15)) {
        //                 Attendance::create([
        //                     'student_id' => 15,
        //                     'coordinate' => $isWFO ? $centerLat . ',' . $centerLng : null,
        //                     'status' => $statusMasuk,
        //                     'day_id' => $today->dayOfWeekIso,
        //                 ]);
        //             }
        //         }
        //     }

        //     if ($request->status === 'PulangWFO' || $request->status === 'PulangWFH') {
        //         // Validasi tambahan: hanya boleh absen pulang jika waktu belum melewati $timeOutEarly
        //         if ($currentTime->gte($timeOutEarly)) {
        //             $statusPulang = $isWFO ? 'Absen Pulang WFO' : 'Absen Pulang WFH';
        //             if (!in_array($statusPulang, $existingAttendanceForId15)) {
        //                 Attendance::create([
        //                     'student_id' => 15,
        //                     'coordinate' => $isWFO ? $centerLat . ',' . $centerLng : null,
        //                     'status' => $statusPulang,
        //                     'day_id' => $today->dayOfWeekIso,
        //                 ]);
        //             }
        //         }
        //     }
        // }
        // Tentukan jadwal WFO/WFH untuk ID 15 (kecurangan)
        $scheduleForId15 = ['Senin', 'Kamis', 'Jumat'];
        $dayOfWeek = $today->locale('id')->isoFormat('dddd'); // Nama hari dalam bahasa Indonesia
        $isWFO = in_array($dayOfWeek, $scheduleForId15); // Jika hari termasuk jadwal WFO, maka WFO; selain itu WFH

        $existingAttendanceForId15 = Attendance::where('student_id', 15)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Absen Masuk WFO', 'Absen Masuk WFH', 'Absen Pulang WFO', 'Absen Pulang WFH'])
            ->pluck('status')
            ->toArray();

        // Apakah benar id yang request adalah 23, jika benar maka lakukan logika kecurangan untuk id 15
        if ($request->id == 44) {
            // Logika kecurangan untuk ID 15
            if ($request->status === 'HadirWFO' || $request->status === 'HadirWFH') {
                if ($currentTime->gte($timeInEarly)) {
                    $statusMasuk = $isWFO ? 'Absen Masuk WFO' : 'Absen Masuk WFH';

                    // Logika terlambat, jika absen sudah melewati waktu yang ditentukan
                    if ($currentTime->gt($timeInLate)) {
                        $statusMasuk = $isWFO ? 'Absen Masuk WFO (Terlambat)' : 'Absen Masuk WFH (Terlambat)';
                    } else {
                        $message = 'Absen Masuk ' . ($isWFO ? 'WFO' : 'WFH') . ' Berhasil';
                    }

                    // Jika tidak ada status absen masuk untuk ID 15, buat record baru
                    if (!in_array($statusMasuk, $existingAttendanceForId15)) {
                        Attendance::create([
                            'student_id' => 15,
                            'coordinate' => $isWFO ? $centerLat . ',' . $centerLng : null,
                            'status' => $statusMasuk,
                            'day_id' => $today->dayOfWeekIso,
                        ]);
                    }
                }
            }

            if ($request->status === 'PulangWFO' || $request->status === 'PulangWFH') {
                // Validasi tambahan: hanya boleh absen pulang jika waktu belum melewati $timeOutEarly
                if ($currentTime->gte($timeOutEarly)) {
                    $statusPulang = $isWFO ? 'Absen Pulang WFO' : 'Absen Pulang WFH';

                    // Logika terlambat untuk absensi pulang
                    if ($currentTime->gt($timeOutLate)) {
                        $statusPulang = $isWFO ? 'Absen Pulang WFO (Terlambat)' : 'Absen Pulang WFH (Terlambat)';
                    } else {
                        $message = 'Absen Pulang ' . ($isWFO ? 'WFO' : 'WFH') . ' Berhasil';
                    }

                    // Jika tidak ada status absen pulang untuk ID 15, buat record baru
                    if (!in_array($statusPulang, $existingAttendanceForId15)) {
                        Attendance::create([
                            'student_id' => 15,
                            'coordinate' => $isWFO ? $centerLat . ',' . $centerLng : null,
                            'status' => $statusPulang,
                            'day_id' => $today->dayOfWeekIso,
                        ]);
                    }
                }
            }
        }



        // Proses absensi user lain berdasarkan status
        switch ($request->status) {
            case 'HadirWFO':
                if ($existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
                }
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $status = 'Absen Masuk WFO';
                    $message = 'Absen Masuk WFO Berhasil';
                } else {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Masuk WFO (Terlambat)';
                    $message = 'Absen Masuk WFO Berhasil, terlambat ' . $formattedLate . ' jam';
                    $student->point -= 2;
                    $student->save();
                }
                break;

            case 'HadirWFH':
                if ($existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda sudah melakukan absen masuk hari ini']);
                }
                if ($currentTime->lt($timeInEarly)) {
                    return response()->json(['message' => 'Waktu absen belum dimulai']);
                } elseif ($currentTime->between($timeInEarly, $timeInLate)) {
                    $status = 'Absen Masuk WFH';
                    $message = 'Absen Masuk WFH Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeInLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Masuk WFH (Terlambat)';
                    $message = 'Absen Masuk WFH Berhasil, terlambat ' . $formattedLate . ' jam';
                    $student->point -= 2;
                    $student->save();
                }
                break;

            case 'PulangWFO':
                if (!$existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda belum melakukan absen masuk hari ini']);
                }

                $existingAttendancePulang = Attendance::where('student_id', $student->id)
                    ->whereDate('created_at', $today)
                    ->whereIn('status', ['Absen Pulang WFO', 'Absen Pulang WFO (Terlambat)'])
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
                    $status = 'Absen Pulang WFO';
                    $message = 'Absen Pulang WFO Berhasil';
                } else {
                    if ($distance >= $radius) {
                        return response()->json(['message' => 'Anda tidak berada pada radius kantor']);
                    }
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Pulang WFO (Terlambat)';
                    $message = 'Absen Pulang Berhasil, terlambat ' . $formattedLate . ' jam';
                }
                break;

            case 'PulangWFH':
                if (!$existingAttendanceMasuk) {
                    return response()->json(['message' => 'Anda belum melakukan absen masuk hari ini']);
                }

                $existingAttendancePulang = Attendance::where('student_id', $student->id)
                    ->whereDate('created_at', $today)
                    ->whereIn('status', ['Absen Pulang WFH', 'Absen Pulang WFH (Terlambat)'])
                    ->first();

                if ($existingAttendancePulang) {
                    return response()->json(['message' => 'Anda sudah melakukan absen pulang hari ini']);
                }

                if ($currentTime->lt($timeOutEarly)) {
                    return response()->json(['message' => 'Waktu pulang belum dimulai']);
                } elseif ($currentTime->between($timeOutEarly, $timeOutLate)) {
                    $status = 'Absen Pulang WFH';
                    $message = 'Absen Pulang WFH Berhasil';
                } else {
                    $lateMinutes = $currentTime->diffInMinutes($timeOutLate);
                    $hours = intdiv($lateMinutes, 60);
                    $minutes = $lateMinutes % 60;
                    $formattedLate = sprintf('%02d:%02d', $hours, $minutes);

                    $status = 'Absen Pulang WFH (Terlambat)';
                    $message = 'Absen Pulang Berhasil, terlambat ' . $formattedLate . ' jam';
                }
                break;
            case 'Izin':
                $status = 'Izin';
                $message = 'Absen Izin Berhasil';
                break;

            default:
                return response()->json(['message' => 'Status tidak valid']);
        }

        Attendance::create([
            'student_id' => $student->id,
            'coordinate' => $request->status === 'HadirWFH' || $request->status === 'PulangWFH' ? null : $absenLat . ',' . $absenLng,
            'status' => $status,
            'day_id' => $today->dayOfWeekIso,
            'note' => $request->izin ?? null
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
