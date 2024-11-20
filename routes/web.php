<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidasiController;

Route::get('/', function () {
    return view('pages.validasi');
});

Route::get('/detail', function () {
    return view('pages.detail');
})->name('detail');

Route::get('/validasi/{id_pengajuan}', [ValidasiController::class, 'show']);
