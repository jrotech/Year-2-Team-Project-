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
        return view('shop');
    }

    public function apiShop(Request $request)
    {
       
        $query = Product::with(['categories', 'images'])
        ->withCount('reviews')
        ->withAvg('reviews', 'rating');


        // Read query params
        $categories = $request->query('categories');
        $search     = $request->query('search');
        $inStock    = $request->query('inStock');
        $minPrice   = $request->query('minPrice', 10);
        $maxPrice   = $request->query('maxPrice', 2500);

        // Filter by categories if not "All"
        if (!empty($categories)) {
            $categoriesArray = explode(',', $categories);
            if (!in_array('All', $categoriesArray)) {
                $query->whereHas('categories', function ($catQuery) use ($categoriesArray) {
                    $catQuery->whereIn('name', $categoriesArray);
                });
            }
        }

        // Filter by price
        $query->whereBetween('price', [(float) $minPrice, (float) $maxPrice]);

        // Filter by search
        if (!empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        // Filter by in stock
        if (!empty($inStock) && $inStock === 'true') {
            $query->where('in_stock', true);
        }

        // Use the Laravel paginator; default 12 items per page
        // page=? in the query string controls which page is returned
        $perPage = 12; 
        $products = $query->paginate($perPage);

        // Append the 'primary_image' and ratings for each product
        $products->getCollection()->transform(function ($product) {
            $product->primary_image = optional($product->images->first())->url;
            $product->average_rating = round($product->average_rating, 1);
            $product->reviews_count = $product->reviews_count;
            return $product;
        });
        

        // Return the paginated result as JSON
        // $products here is a LengthAwarePaginator, which includes total pages, etc.
        return response()->json($products);
    }
}
