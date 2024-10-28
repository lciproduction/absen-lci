<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use App\Models\Absentee;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // $sql = $attendances->toSql();

        if (request()->ajax()) {
            $attendances = Attendance::query();
            if ($user->roles->pluck('name')[0] == 'teacher') {
                $attendances->whereHas('schedule.subject', function ($query) use ($user) {
                    $query->where('teacher_id', $user->teacher->id);
                })->with('schedule.subject')->get();
            } else {
                $attendances->get();
            }

            if ($request->has('from') && $request->has('to')) {
                $from = Carbon::parse($request->input('from'))->startOfDay();
                $to = Carbon::parse($request->input('to'))->endOfDay();
                $attendances->whereBetween('created_at', [$from, $to]);
            }

            return DataTables::of($attendances)
                ->make();
        }
        return view('dashboard.attendance.index');
    }

    public function export(Request $request)
    {
        $from = $request->fromExport;
        $to = $request->toExport;
        return Excel::download(new AttendanceExport($from, $to), 'Data Absensi Siswa.xlsx');
    }

    public function show(Attendance $attendance)
    {
        return view('dashboard.attendance.show', compact('attendance'));
    }



    public function checkAbsentees()
    {
        $today = Carbon::today();
        $formattedDate = $today->translatedFormat('l, d F Y'); // Format hari, tanggal, bulan, tahun

        // Dapatkan daftar semua mahasiswa
        $allStudents = Student::all();

        // Dapatkan daftar mahasiswa yang sudah hadir pada hari ini
        $attendedStudents = Attendance::whereDate('created_at', $today)
            ->pluck('student_id')
            ->toArray();

        // Dapatkan daftar mahasiswa yang belum hadir
        $absentStudents = $allStudents->whereNotIn('id', $attendedStudents);

        return view('student.attendance.absentees', compact('absentStudents', 'formattedDate'));
    }



    public function saveAbsentees()
    {
        $today = Carbon::today();

        // Dapatkan semua mahasiswa
        $allStudents = Student::all();

        // Dapatkan mahasiswa yang sudah hadir hari ini
        $attendedStudents = Attendance::whereDate('created_at', $today)
            ->pluck('student_id')
            ->toArray();

        // Identifikasi mahasiswa yang belum hadir
        $absentStudents = $allStudents->whereNotIn('id', $attendedStudents);

        foreach ($absentStudents as $student) {
            Absentee::create([
                'student_id' => $student->id,
                'date' => $today,
                'reason' => 'Tidak hadir tanpa keterangan',
            ]);
        }


        return redirect('/attendance')->with('success', 'Data ketidakhadiran berhasil disimpan');
    }
}
