<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class ShopController extends Controller
{
    public function shop(Request $request)
    {

        $products = Product::all(); // Retrieve all products from the database
        return view('shop', ['products' => $products]); // Pass products to the view
    }
}
