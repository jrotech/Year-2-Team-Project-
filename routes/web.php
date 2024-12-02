<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\login;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;


// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Footer Buttons
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/social-media', [HomeController::class, 'socialMedia'])->name('social-media');
Route::get('/payment-methods', [HomeController::class, 'paymentMethods'])->name('payment-methods');

// Nav Bar Links
Route::get('/wishlist', [NavController::class, 'wishlist'])->name('wishlist');
Route::get('/cart', [NavController::class, 'cart'])->name('cart');
Route::get('/about', [NavController::class, 'about'])->name('about');
Route::get('/pc-builder', [NavController::class, 'pcBuilder'])->name('pc-builder');
Route::get('/login', [NavController::class, 'login'])->name('login');

// Search / Shop Page
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');

// Product
Route::get('/shop/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Submit Contact Form
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');



Route::get('/register', [register::class,'create'])->name('register');
Route::post('/register', [register::class,'store'])->name('register');

Route::get('/login', [login::class,'create'])->name('login');
Route::post('/login', [login::class,'login'])->name('login');
Route::get('/logout', [login::class,'logout'])->name('logout');

Route::get('/auth/google',[GoogleAuthController::class,'redirect']);
Route::get('/authenticate/google/callback',[GoogleAuthController::class,'callback']);


Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [BasketController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [BasketController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [BasketController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [BasketController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [BasketController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/cart/checkout', [BasketController::class, 'proceedToCheckout'])->name('cart.checkout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
