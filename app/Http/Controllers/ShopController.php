<?php

namespace App\Http\Controllers;
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function shop()
    {
        // Fetch products with their categories and first image
        $products = Product::with(['categories', 'images'])
            ->get()
            ->map(function ($product) {
                // Add a 'primary_image' field for convenience
                $product->primary_image = $product->images->first()->url ?? null;
                return $product;
            ;

        // Return view with products data
        return view('shop', ['products' => $products]);
    }
}
