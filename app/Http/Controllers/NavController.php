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

    public function cart()
    {
        return view('cart'); // Replace with actual cart logic
    }

    public function shop(Request $request)
    {
        $searchQuery = $request->input('query', '');
        $category = $request->input('category', 'all');

        $products = Product::when($searchQuery, function ($query, $searchQuery) {
            return $query->where('name', 'like', '%' . $searchQuery . '%');
        })->when($category !== 'all', function ($query) use ($category) {
            return $query->where('category', $category);
        })->get();

        return view('shop', [
            'products' => $products,
            'searchQuery' => $searchQuery,
            'category' => ucfirst(str_replace('-', ' ', $category)),
        ]);
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
