<?php

use Illuminate\Support\Facades\Route;

// Route yang mengarah ke view edit_pengajuan
Route::get('/', function () {
    return view('edit_pengajuan'); // pastikan file view ini ada di resources/views/edit_pengajuan.blade.php
});
