<?php

use App\Http\Controllers\OrderController;

Route::get('/cart', [OrderController::class, 'cart'])->name('cart.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}/payconfirm', [OrderController::class, 'showPayConfirm'])->name('orders.payconfirm');