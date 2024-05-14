<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.get');
Route::put('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart', [CartController::class, 'removeFromCart'])->name('cart.delete');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/save', [CartController::class, 'saveCart'])->name('cart.save');