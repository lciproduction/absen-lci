<?php

namespace App\Console\Commands;

use App\Models\Absentee;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsentees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mark:absentees';
    protected $description = 'Menandai mahasiswa yang tidak absen hari ini sebagai absentees';


    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Check if today is a weekend (Saturday or Sunday)
        if ($today->isWeekend()) {
            $this->info('Skipping marking absentees as today is a weekend.');
            return;
        }


        // Ambil semua student
        $students = Student::all();

        foreach ($students as $student) {
            // Cek apakah student sudah absen hari ini
            $isPresent = Attendance::where('student_id', $student->id)
                ->whereDate('created_at', $today)
                ->exists();

            // Jika belum absen, tambahkan ke absentees
            if (!$isPresent) {
                Absentee::updateOrCreate(
                    ['student_id' => $student->id, 'date' => $today],
                    ['reason' => 'Tidak absen']
                );
            }
        }
    }
}
