<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TrackingController;


Route::get('/', function () {
    return view('progress2');
});


// Route untuk menampilkan daftar pengajuan
Route::get('/pengajuan/{id_pengajuan}', [PengajuanController::class, 'index'])->name('pengajuan.index');

// Route untuk menampilkan form pengajuan baru
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');

// Route untuk menyimpan data pengajuan baru
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

// Routes untuk Status Tracker
Route::get('/tracking/{id_pengajuan}', [TrackingController::class, 'show'])->name('tracking.show');