<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/shop/product/{id}', function ($id) {
    return view('product', ['id' => $id]);
});
