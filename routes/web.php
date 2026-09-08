<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homepage', [App\Http\Controllers\HomepageController::class, 'index']);

use App\Http\Controllers\RegisterpageController;

// Route Tampil Halaman Register
Route::get('/register', [RegisterpageController::class, 'index'])->name('register');

// Route Proses Submit Register (POST)
Route::post('/register', [RegisterpageController::class, 'store'])->name('register.store');

