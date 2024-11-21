<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\login;
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
