<?php
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;

class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Stock::with('product')
         ->orderBy('quantity', 'asc')
         ->limit(3)
         ->get();
        $categories = Category::all();

        return view('home', compact('bestSellers', 'categories'));
    }

    public function about()
    {
        return view('about'); 
    }

    public function paymentMethods()
    {
        return view('payment-methods'); // Replace with the actual payment methods page
    }
}
