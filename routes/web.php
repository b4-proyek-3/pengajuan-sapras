<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TrackingController;

Route::get('/', function () {
    return view('progress2');
});

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
    // Route untuk menyimpan data pengajuan baru
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.form');

    // === Detail Pengajuan Route ==== //
    Route::get('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.update');

    // Route untuk menampilkan page pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

    // Route untuk menyimpan data pengajuan baru
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

    // Route untuk reviewer
    Route::get('/reviewer', [ReviewController::class, 'index'])->name('reviewer.index');
    Route::get('/reviewer/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'detailReviewer'])->name('reviewer.detail_reviewer');
    Route::post('/reviewer/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'updateReview'])->name('update.review');

    // Routes untuk Status Tracker
    Route::get('/tracking/{id_pengajuan}', [TrackingController::class, 'show'])->name('tracking.show');
});

Route::get('/validasi/{id_pengajuan}', [ValidasiController::class, 'show'])->name('validasi.show');
