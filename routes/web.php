<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.test');
});

Route::get('/detail', function () {
    return view('pages.detail');
})->name('detail');