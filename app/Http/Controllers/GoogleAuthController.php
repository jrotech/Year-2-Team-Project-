<?php

/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller allows the user to log in with Google
 ********************************/
namespace App\Http\Controllers;
use Illuminate\Support\Str;
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
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if the customer exists by google_id
            $findCustomer = Customer::where('google_id', $googleUser->getId())->first();

            if ($findCustomer) {
                Auth::guard('customer')->login($findCustomer);
                return redirect()->intended('/');
            } else {
                // If customer doesn't exist, check if email exists
                $existingCustomer = Customer::where('email', $googleUser->getEmail())->first();

                if ($existingCustomer) {
                    $existingCustomer->google_id = $googleUser->getId();
                    $existingCustomer->save();
                    Auth::guard('customer')->login($existingCustomer);
                } else {
                    // Create a new customer
                    $newCustomer = Customer::create([
                        'customer_name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'email_confirmed' => true, // Since it's Google OAuth
                        'phone_number' => null,
                        'prev_balance' => 0,
                        'password' => bcrypt(Str::random(16)) // Using Str facade instead of str_random
                    ]);

                    Auth::guard('customer')->login($newCustomer);
                }
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to login with Google. ' . $e->getMessage());
        }
    }
}
