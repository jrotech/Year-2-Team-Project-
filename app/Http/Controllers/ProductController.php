<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        return view('product');
    }
    
    public function getProduct($id)
    {
        $product = Product::with(['categories', 'images'])->findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'in_stock' => $product->in_stock,
            'categories' => $product->categories,
            'images' => $product->images->map(function ($image) {
                return [
                    'url' => asset('storage/' . $image->url),
                    'alt' => $image->alt ?? 'Product Image',
                ];
            }),
        ]);
    }
}
