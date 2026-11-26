<?php

use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\MenuController as CustomerMenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('menu.index');
});

Route::get('/menu', [CustomerMenuController::class, 'index'])->name('menu.index');

// Guest auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated customer routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/cart', [UserController::class, 'cart'])->name('cart.index');
    Route::get('/cart/empty', function () {
        return view('users.cart-empty');
    })->name('cart.empty');
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders.index');
    Route::get('/order-confirmed', [UserController::class, 'payConfirm'])->name('orders.confirmed');
});

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'admin'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminController::class, 'orderManagement'])->name('orders.index');

        Route::resource('menus', AdminMenuController::class)->except(['show']);
        Route::patch('/menus/{menu}/toggle', [AdminMenuController::class, 'toggle'])->name('menus.toggle');

        Route::get('/users', [AdminController::class, 'userManagement'])->name('users.index');
    });
