<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller register a new customer to the database
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
        if(Auth::check()){
            return redirect('/');
        }
        return view('login');
    }

    // login a registered user
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $email  = $request->email;
        $password = $request->password;

        // try to login the user
        if(Auth::attempt(['email' => $email, 'password' => $password])){

            return redirect('/');
        }
        // redirect if the login failed
        return redirect('/login')->with('error','Email or Password is Incorrect');
    }

    // logout the user
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}
