<?php

use App\Http\Controllers\AcaraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\ChangeAdminPassword;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Teacher\AgendaController;
use App\Http\Controllers\Student\HistoryController;
use App\Http\Controllers\Student\SubjectController as StudentSubjectController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Models\User;
use Illuminate\Support\Facades\Log;

Route::prefix('')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    // change password
    Route::get('/changepassword', [ChangePasswordController::class, 'index'])->name('changepassword.index');
    Route::post('/setting/update', [ChangePasswordController::class, 'update'])->name('changepassword.store');

    Route::prefix('karyawan')->name('student.')->middleware(['role:student'])->group(function () {
        // Route::get('/subject', action: [StudentSubjectController::class, 'index'])->name('subject.index');
        Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [StudentAttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/{attendance}', [HistoryController::class, 'show'])->name('history.show');
        Route::delete('/history/{attendance}', [HistoryController::class, 'destroy'])->name('history.destroy');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('siswa.profile.edit');
        Route::post(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');

        // Acara
        Route::get('/acara', [AcaraController::class, 'karyawan'])->name('acara.karyawan');
    });

    // Route::prefix('guru')->name('teacher.')->middleware(['role:teacher'])->group(function () {
    //     Route::resource('/agenda', AgendaController::class)->except('show');
    //     Route::post('/search', [AgendaController::class, 'getClass'])->name('search');
    // });


    Route::group(['middleware' => ['role:teacher|admin']], function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/karyawan', [StudentController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/create', [StudentController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan/store', [StudentController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{karyawan}/edit', [StudentController::class, 'edit'])->name('karyawan.edit');
        Route::patch('/karyawan/{karyawan}', [StudentController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{karyawan}', [StudentController::class, 'destroy'])->name('karyawan.destroy');
        // Route::resource('/teacher', TeacherController::class)->except('show');
        // Route::resource('/subject', SubjectController::class)->except('show');
        // Route::resource('/schedule', ScheduleController::class)->except('show');
        Route::post('/student/import', [StudentController::class, 'import'])->name('student.import');
        Route::post('/student/export', [StudentController::class, 'export'])->name('student.export');

        // Route::post('/teacher/import', [TeacherController::class, 'import'])->name('teacher.import');
        // Route::get('/teacher/export', [TeacherController::class, 'export'])->name('teacher.export');

        // Route::post('/subject/import', [SubjectController::class, 'import'])->name('subject.import');
        // Route::get('/subject/export', [SubjectController::class, 'export'])->name('subject.export');

        Route::get('/time', [TimeController::class, 'index'])->name('time.index');
        Route::post('/time', [TimeController::class, 'store'])->name('time.store');

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting', [SettingController::class, 'store'])->name('setting.store');

        Route::get('/acara', [AcaraController::class, 'index'])->name('acara.index');
        Route::get('/acara/create', [AcaraController::class, 'create'])->name('acara.create');
        Route::post('/acara/store', [AcaraController::class, 'store'])->name('acara.store');
        // Rute untuk menampilkan form edit acara
        Route::get('/acara/{acara}/edit', [AcaraController::class, 'edit'])->name('acara.edit');
        // Rute untuk memperbarui acara yang ada
        Route::patch('/acara/{acara}', [AcaraController::class, 'update'])->name('acara.update');

        // Rute untuk menghapus acara
        Route::delete('/acara/{acara}', [AcaraController::class, 'destroy'])->name('acara.destroy');

        // Store Absentess to DB
        Route::get('/checkabsen', [AttendanceController::class, 'checkAbsentees'])->name('attendance.check_absentees');
        Route::post('/attendance/save-absentees', [AttendanceController::class, 'saveAbsentees'])->name('attendance.save_absentees');
    });
});
require __DIR__ . '/auth.php';
