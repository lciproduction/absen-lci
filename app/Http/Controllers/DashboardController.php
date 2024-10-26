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
                      ->orWhere('status', 'Absen Masuk');
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



    // Mendapatkan data hari berdasarkan nama hari yang diterjemahkan
    $day = Day::where('name', $today)->first();


    // Mencari siswa yang mempunyai hari wajib di hari ini namun tidak hadir
    $studentsAbsent = Student::whereHas('days', function ($query) use ($day) {
        $query->where('day_id', $day->id);

    })->whereDoesntHave('attendances', function ($query) use ($day) {
        $query->where('day_id', $day->id)
              ->whereDate('created_at', today());
    })->get();

    // dd($studentsAbsent);


        return view('dashboard', compact('hadir', 'sakit', 'izin', 'attendances', 'studentsAbsent'));
    }
}
