<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller login  an existing user
 ********************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


class login extends Controller
{
    // display the login page
    public function create(){
        return view('login');
    }

    // login a registered user
    public function login(Request $request){
        $request->validate([
            'CustomerEmail'=>'required',
            'CustomerPassword'=>'required'
        ]);

        $email  = $request->CustomerEmail;
        $password = $request->CustomerPassword;

        // try to login the customer
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            return redirect()->to('/')->with('success', 'Logged in!')->setStatusCode(303);

        }
        // redirect if the login failed
        return redirect('/login')->with('error','Email or Password is Incorrect');
    }

    // logout the customer
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}
