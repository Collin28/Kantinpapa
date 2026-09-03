<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homepage', [App\Http\Controllers\HomepageController::class, 'index']);