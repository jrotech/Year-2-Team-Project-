<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class NavController extends Controller
{
    public function wishlist()
    {
        return view('wishlist'); // Replace with actual wishlist logic
    }

    public function basket()
    {
        return view('basket'); // Replace with actual basket logic
    }

  

    public function about()
    {
        return view('about');
    }

    public function pcBuilder()
    {
        return view('pc-builder');
    }

    public function login()
    {
        return view('login');
    }
}
