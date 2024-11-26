<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Product::where('is_best_seller', true)->get();
        $categories = Category::all();

        return view('home', compact('bestSellers', 'categories'));
    }

    public function socialMedia()
    {
        return redirect('https://instagram.com'); // Replace with the actual link
    }

    public function paymentMethods()
    {
        return view('payment-methods'); // Replace with the actual payment methods page
    }
}
