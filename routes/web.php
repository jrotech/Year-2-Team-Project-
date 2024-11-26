<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\ContactController;

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
Route::get('/shop', [NavController::class, 'shop'])->name('shop');


// Submit Contact Form
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
