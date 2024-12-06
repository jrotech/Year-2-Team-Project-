<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller register a new customer to the database
 ********************************/
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class register extends Controller
{
    // display the registration page
    public function create()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('Registration');
    }

    // store the customer information
    public function store(Request $request){
        $request->validate([
            'CustomerName' => 'required',
            'CustomerEmail' => 'required',
            'CustomerPassword' => 'required',
            'CustomerPhone' => 'required',
        ]);
        $info['customer_name'] = $request->CustomerName;
        $info['email'] = $request->CustomerEmail;
        $info['password'] = $request->CustomerPassword;
        $info["phone_number"] = $request->CustomerPhone;
        $customer = Customer::create($info);

        if(!$customer){
            return back()->with('error','Registration failed');
        }
        return redirect('/login')->with('registered','Registration successful');

    }
}
