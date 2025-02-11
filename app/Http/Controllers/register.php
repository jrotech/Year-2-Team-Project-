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
        if (Auth::check()) {
            return redirect('/');
        }
        return view('Registration');
    }

    // store the customer information
    public function store(Request $request)
{
    // Validate input fields including password confirmation
    $request->validate(
        [
            'CustomerName' => 'required|string|max:255',
            'CustomerEmail' => 'required|email|unique:customers,email',
            'CustomerPassword' => 'required|confirmed|min:8',
            'CustomerPhone' => 'required|numeric|digits_between:10,15',
        ],
        [
            // Custom message for password confirmation failure
            'CustomerPassword.confirmed' => 'The passwords do not match.',
        ]
    );

    // Prepare data for insertion
    $info['customer_name'] = $request->CustomerName;
    $info['email'] = $request->CustomerEmail;
    $info['password'] = Hash::make($request->CustomerPassword);
    $info['phone_number'] = $request->CustomerPhone;

    // Create the customer record
    $customer = Customer::create($info);

    // Handle success or failure
    if (!$customer) {
        return back()->with('error', 'Registration failed');
    }

    return redirect('/login')->with('registered', 'Registration successful');
}
}
