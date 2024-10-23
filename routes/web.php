<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;

// Route yang mengarah ke view edit_pengajuan
Route::get('/', function () {
    return view('pages.test'); // pastikan file view ini ada di resources/views/edit_pengajuan.blade.php
});


// Route untuk menampilkan daftar pengajuan
Route::get('/pengajuan/{id_pengajuan}', [PengajuanController::class, 'index'])->name('pengajuan.index');

// Route untuk menampilkan form pengajuan baru
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');

// Route untuk menyimpan data pengajuan baru
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');