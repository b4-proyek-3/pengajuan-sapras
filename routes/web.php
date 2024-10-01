<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::prefix('pengajuan')->group(function () {
    // Display the main pengajuan view
    Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');

    // Display the form for submitting a new pengajuan
    //Route::get('/form', [PengajuanController::class, 'create'])->name('pengajuan.create'); 
    Route::post('/', [PengajuanController::class, 'form'])->name('pengajuan.form'); 

    Route::post('/pengajuan', [PengajuanController::class, 'store']);

    // Show the details of a specific pengajuan
    //Route::get('details', [PengajuanController::class, 'details'])->name('pengajuan.details'); // Include ID as a parameter
});
