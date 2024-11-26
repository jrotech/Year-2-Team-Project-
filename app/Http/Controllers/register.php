<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller register a new customer to the database
 ********************************/
namespace App\Http\Controllers;

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
        return view('register');
    }

    // store the customer information
    public function store(Request $request){
        $request->validate([
            'customer_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
        ]);
        $info['customer_name'] = $request->customer_name;
        $info['email'] = $request->email;
        $info['password'] = $request->password;
        $info["phone_number"] = $request->phone_number;
        $user = User::create($info);

        if(!$user){
            return back()->with('error','Registration failed');
        }
        return redirect('/login')->with('registered','Registration successful');

    }
}
