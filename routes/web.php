<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

//Auth
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
});

//User
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/orderhistory', [UserController::class, 'orderHistory'])->name('orderhistory');
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::get('/payconfirm', [UserController::class, 'payConfirm'])->name('payconfirm');
});

//Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/ordermanage', [AdminController::class, 'order'])->name('order');
    Route::get('/menumanage', [AdminController::class, 'menu'])->name('menu');
    Route::get('/usermanage', [AdminController::class, 'user'])->name('user');
});

