<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;

Route::get('/', function () {
    return view('test');
});

// Route untuk menampilkan page pengajuan
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

// Route untuk menyimpan data pengajuan baru
Route::post('/pengajuan/form', [PengajuanController::class, 'form'])->name('pengajuan.form');

// Route untuk menampilkan daftar pengajuan
Route::get('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'index'])->name('pengajuan.index');