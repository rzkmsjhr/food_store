<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.get');
Route::put('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart', [CartController::class, 'removeFromCart'])->name('cart.delete');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/save', [CartController::class, 'saveCart'])->name('cart.save');
Route::prefix('secret')->group(function () {
    Route::get('/admin', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/coupons/create', [AdminController::class, 'createCoupon'])->name('admin.coupons.create');
    Route::post('/admin/coupons', [AdminController::class, 'storeCoupon'])->name('admin.coupons.store');


})->middleware('guest');