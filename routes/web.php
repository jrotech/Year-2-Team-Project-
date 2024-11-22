<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\login;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/register', [register::class,'create'])->name('register');
Route::post('/register', [register::class,'store'])->name('register');

Route::get('/login', [login::class,'create'])->name('login');
Route::post('/login', [login::class,'login'])->name('login');
Route::get('/logout', [login::class,'logout'])->name('logout');

Route::get('/auth/google',[GoogleAuthController::class,'redirect']);
Route::get('/authenticate/google/callback',[GoogleAuthController::class,'callback']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [BasketController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [BasketController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [BasketController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [BasketController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [BasketController::class, 'clear'])->name('cart.clear');
});

Route::middleware(['auth'])->group(function () {
    // Existing cart routes...

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});
