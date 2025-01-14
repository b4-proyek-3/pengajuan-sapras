<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard1Controller;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\StatusPengajuanController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\JadwalUjianController;
use App\Http\Controllers\CalendarController;
use App\Models\Dokumen;


// ========================================================================================
// AUTHENTICATION ROUTES ==================================================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login.submit');

    // Forgot password process
    Route::post('/forgot-password', 'forgotPassword')->name('password.forgot');
    Route::post('/verify-code', 'verifyCode')->name('password.verifyCode');
    Route::get('/reset-password', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');

    // Logout route should be outside the '/home' route
    Route::post('/logout', 'logout')->name('logout');
});

// PROTECTED ROUTES (Require Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::delete('/pengajuan/{id_pengajuan}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');

    // Detail Pengajuan Route
    Route::get('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.update');

    // Route untuk reviewer
    Route::get('/reviewer', [ReviewController::class, 'index'])->name('reviewer.index');
    Route::get('/reviewer/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'detailReviewer'])->name('reviewer.detail_reviewer');
    Route::post('/reviewer/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'updateReview'])->name('update.review');

    // Routes untuk Status Tracker
    Route::get('/tracking/{id_pengajuan}', [TrackingController::class, 'show'])->name('tracking.show');
    Route::post('/pengajuan/{id_pengajuan}/submit', [PengajuanController::class, 'submitPengajuan'])->name('pengajuan.submit');
    Route::put('/pengajuan/{id_pengajuan}/update', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::get('/dokumen/generate/{id_pengajuan}', [DokumenController::class, 'generate'])->name('dokumen.generate');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard1', [Dashboard1Controller::class, 'index'])->name('dashboard1');

    Route::resource('menggunakan-ruangan', MenggunakanRuanganController::class);
    Route::get('/status-pengajuan', [StatusPengajuanController::class, 'index'])->name('layout.status');

    // Rute untuk CRUD Ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    // Rute untuk CRUD Gedung
    Route::get('/gedung', [GedungController::class, 'index'])->name('gedung.index');
    Route::post('/gedung', [GedungController::class, 'store'])->name('gedung.store');
    Route::get('/gedung/{gedung}/edit', [GedungController::class, 'edit'])->name('gedung.edit');
    Route::put('/gedung/{gedung}', [GedungController::class, 'update'])->name('gedung.update');
    Route::delete('/gedung/{gedung}', [GedungController::class, 'destroy'])->name('gedung.destroy');

    Route::prefix('jadwal')->group(function () {
        Route::get('/', [JadwalUjianController::class, 'index'])->name('jadwal.index');
        Route::post('/', [JadwalUjianController::class, 'store'])->name('jadwal.store');
        Route::put('/{id}', [JadwalUjianController::class, 'update'])->name('jadwal.update');
        Route::delete('/{id}', [JadwalUjianController::class, 'destroy'])->name('jadwal.destroy');
    });

    Route::get('/calendar', [CalendarController::class, 'showCalendar'])->name('calendar');
    Route::get('/get-calendar-data', [CalendarController::class, 'getCalendarData']);

});

Route::get('/validasi/{id_pengajuan}', [ValidasiController::class, 'show'])->name('validasi.show');
