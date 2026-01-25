<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::latest()->take(4)->get();
    return view('landing', compact('products'));
});

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/materi', [MateriController::class, 'index'])->name('materi');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'index'])->name('buyer.dashboard');
    Route::get('/payment/checkout/{product}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/orders/export', [\App\Http\Controllers\OrderController::class, 'export'])->name('admin.orders.export');
        Route::resource('orders', \App\Http\Controllers\OrderController::class)->names([
            'index' => 'admin.orders.index',
            'create' => 'admin.orders.create',
            'store' => 'admin.orders.store',
            'edit' => 'admin.orders.edit',
            'update' => 'admin.orders.update',
            'destroy' => 'admin.orders.destroy',
        ]);
        Route::resource('products', ProductController::class)->except(['index', 'show'])->names([
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
    });
});