<?php

/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller allows the user to log in with Google
 ********************************/
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        dd($request->all());
        try {
//            $googleUser = Socialite::driver('google')->user();
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if the customer exists by google_id
            $findCustomer = Customer::where('google_id', $googleUser->getId())->first();

            if ($findCustomer) {

                echo("Customer exists");
                // If customer exists, log them in
                Auth::login($findCustomer);
                return redirect()->intended('/');
            } else {
                // If customer doesn't exist, check if email exists
                $existingCustomer = Customer::where('email', $googleUser->getEmail())->first();
                echo("Customer does not exist");
                if ($existingCustomer) {
                    echo("email Exists");
                    // If email exists, update google_id and log in
                    $existingCustomer->google_id = $googleUser->getId();
                    $existingCustomer->save();
                    Auth::login($existingCustomer);
                } else {
                    echo("email does not exist, making new customer");
                    // Create a new customer
                    $newCustomer = Customer::create([
                        'customer_name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                    ]);
                    echo("customer created");

                    Auth::login($newCustomer);
                    echo("logged in");
                }
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            // Handle the error, show a message

            dd("Failed to log in. Please try again later. " . $e->getMessage(), $e->getTrace());
        }
    }
}
