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
    // Regular shop page
    public function shop()
    {
        // Return the main view. 
        // We won't pass all products here anymore — we’ll fetch them via JS from /api/products.
        return view('shop');
    }

    // API endpoint to filter products server-side
    public function apiShop(Request $request)
    {
        // Start a query with the necessary relationships.
        $query = Product::with(['categories', 'images']);

        // Retrieve query params
        // e.g. ?categories=Electronics,Fashion&search=iphone&inStock=true&minPrice=10&maxPrice=2500
        $categories = $request->query('categories');
        $search     = $request->query('search');
        $inStock    = $request->query('inStock');
        $minPrice   = $request->query('minPrice', 10);    
        $maxPrice   = $request->query('maxPrice', 2500);

        // Handle categories filter
        // If no 'All' in the categories and categories is present, we can apply a category filter.
        // categories is expected to be comma-separated: "Electronics,Fashion"
        if (!empty($categories)) {
            $categoriesArray = explode(',', $categories);

            if (!in_array('All', $categoriesArray)) {
                // Filter products where product has at least one of the specified categories
                $query->whereHas('categories', function($catQuery) use ($categoriesArray) {
                    $catQuery->whereIn('name', $categoriesArray);
                });
            }
        }

        // Handle price range filter
        $query->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);

        // Handle search filter
        if (!empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        // Handle inStock
        if (!empty($inStock) && $inStock === 'true') {
            $query->where('in_stock', true);
        }

        // Execute the query
        $products = $query
            ->get()
            ->map(function($product) {
                // Attach the first image URL as 'primary_image'
                $product->primary_image = $product->images->first()->url ?? null;
                return $product;
            });

        // Return JSON
        return response()->json($products);
    }
}
