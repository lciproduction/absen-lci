<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Day;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil hari ini menggunakan Carbon, namun hanya ambil dayOfWeek (0 = Minggu, 1 = Senin, dst.)
        $today = Carbon::now()->dayOfWeek;

        // Menghitung hadir, sakit, izin pada hari ini
        $hadir = Attendance::whereDate('created_at', Carbon::today())
            ->where(function ($query) {
                $query->where('status', 'like', '%terlambat%')
                    ->orWhere('status', ['Absen Masuk WFH', 'Absen Masuk WFO']);
            })
            ->count();

        $sakit = Attendance::whereDate('created_at', Carbon::today())
            ->where('status', 'Sakit')
            ->count();

        $izin = Attendance::whereDate('created_at', Carbon::today())
            ->where('status', 'Izin')
            ->count();

        // Mengambil semua absensi untuk hari ini
        $attendances = Attendance::whereDate('created_at', Carbon::today())->get();


        // Mendapatkan nama hari saat ini dalam bahasa Inggris
        $todayEnglish = Carbon::now()->isoFormat('dddd');

        // Pemetaan hari dari Inggris ke Indonesia
        $dayTranslations = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        // Menerjemahkan hari dari bahasa Inggris ke Indonesia
        $today = $dayTranslations[$todayEnglish] ?? null;





        // Mencari siswa yang mempunyai hari wajib di hari ini namun tidak hadir
        $allStudents = Student::pluck('id')->toArray();

        // Ambil siswa yang sudah mengisi absensi hari ini
        $studentsPresent = Attendance::whereDate('created_at', Carbon::today())
            ->pluck('student_id')
            ->toArray();

        // Cari siswa yang tidak mengisi absensi
        $studentsAbsent = array_diff($allStudents, $studentsPresent);



        // Jika Anda ingin mendapatkan objek siswa, Anda bisa menggunakan:
        $absentStudents = Student::whereIn('id', $studentsAbsent)->get();
        // dd($absentStudents);
        // dd($studentsAbsent);


        return view('dashboard', compact('hadir', 'sakit', 'izin', 'attendances', 'absentStudents'));
    }
}
