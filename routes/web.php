<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('users.home');
Route::get('/cart', [UserController::class, 'cart'])->name('users.cart');
Route::post('/cart/{menu}', [UserController::class, 'addToCart'])->name('users.cart.add');
Route::patch('/cart/{menu}', [UserController::class, 'updateCart'])->name('users.cart.update');
Route::delete('/cart/{menu}', [UserController::class, 'removeFromCart'])->name('users.cart.remove');
Route::post('/checkout', [UserController::class, 'checkout'])->name('users.checkout');
Route::get('/orders', [UserController::class, 'orderHistory'])->name('users.orders');
Route::get('/orders/{order}', [UserController::class, 'payConfirm'])->name('users.orders.confirmation');
