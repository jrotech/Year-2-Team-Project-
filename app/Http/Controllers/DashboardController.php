<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    public function dashboard()
    {
        return view('dashboard');
    }

    public function orders()
    {
        return view('orders');
    }

    
  
    public function order($id)
    {
        return view('order', compact('id'));
    }
}
