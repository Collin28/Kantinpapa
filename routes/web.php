<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\MenuController as CustomerMenuController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Webhook\QrisWebhookController;
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
    Route::post('/register', [AuthController::class, 'store'])->middleware('throttle:10,1');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated customer routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{menu}', [CartController::class, 'store'])->middleware('throttle:30,1')->name('cart.store');
    Route::patch('/cart/{menu}', [CartController::class, 'update'])->middleware('throttle:30,1')->name('cart.update');
    Route::delete('/cart/{menu}', [CartController::class, 'destroy'])->middleware('throttle:30,1')->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'review'])->name('checkout.review');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('throttle:20,1')->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/confirmed', [OrderController::class, 'confirmed'])->name('orders.confirmed');
    Route::get('/orders/{order}/pay', [PaymentController::class, 'show'])->name('orders.pay');
    Route::post('/orders/{order}/pay/simulate', [PaymentController::class, 'simulate'])->middleware('throttle:20,1')->name('orders.pay.simulate');
    Route::get('/orders/{order}/status', [PaymentController::class, 'status'])->middleware('throttle:60,1')->name('orders.status');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->middleware('throttle:20,1')->name('orders.reorder');
});

// QRIS Webhook
Route::post('/webhooks/qris', QrisWebhookController::class)
    ->middleware('throttle:60,1')
    ->name('webhooks.qris');

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::resource('menus', AdminMenuController::class)->except(['show']);
        Route::patch('/menus/{menu}/toggle', [AdminMenuController::class, 'toggle'])->name('menus.toggle');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
        Route::patch('/users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
