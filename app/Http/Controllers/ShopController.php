<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class ShopController extends Controller
{
    public function shop()
    {
        // Fetch products with their categories
        $products = Product::with('categories')->get();
    
        // Return view with products data
        return view('shop', ['products' => $products]);
    }
}
