<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminController::class, 'orderManagement'])->name('orders');
    Route::get('/menus', [AdminController::class, 'menuManagement'])->name('menus');
    Route::get('/users', [AdminController::class, 'userManagement'])->name('users');
});

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::get('/pay-confirm', [UserController::class, 'payConfirm'])->name('payConfirm');
});
