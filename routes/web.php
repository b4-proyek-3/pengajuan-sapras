<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;

// Route untuk menampilkan daftar pengajuan
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

// Route untuk menampilkan form pengajuan baru
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');

// Route untuk menyimpan data pengajuan baru
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');