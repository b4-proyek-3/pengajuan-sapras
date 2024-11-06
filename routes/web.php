<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ReviewController;

// Route yang mengarah ke view edit_pengajuan
Route::get('/', function () {
    return view('pages.test'); // pastikan file view ini ada di resources/views/edit_pengajuan.blade.php
});


// Route untuk menampilkan daftar pengajuan
Route::get('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'show'])->name('pengaju.show');
Route::put('/pengajuan/detail/{id_pengajuan}', [PengajuanController::class, 'update'])->name('pengaju.update');

// Route untuk menampilkan form pengajuan baru
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');

// Route untuk menyimpan data pengajuan baru
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

// Route untuk reviewer
Route::get('/pengajuan/review/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'detailReviewer'])->name('reviewer.detail_reviewer');
Route::post('/pengajuan/review/{id_pengajuan}/{id_reviewer}', [ReviewController::class, 'storeReview'])->name('store_review');

