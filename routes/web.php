<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    
Route::post('/pengajuan/form', [PengajuanController::class, 'form'])->name('pengajuan.form');
