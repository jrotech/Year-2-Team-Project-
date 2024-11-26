<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Retrieve the search query from the request
        $searchQuery = $request->input('query');

        // Pass the search query to the shop view (optional for future use)
        return view('shop', ['query' => $searchQuery]);
    }
}
