<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller allows the user to log in with Google
 ********************************/
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if the user exists by google_id
            $findUser = User::where('google_id', $googleUser->getId())->first();

            if ($findUser) {
                // If user exists, log them in
                Auth::login($findUser);
                return redirect()->intended('/');
            } else {
                // If user doesn't exist, check if email exists
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    // If email exists, update google_id and log in
                    $existingUser->google_id = $googleUser->getId();
                    $existingUser->save();
                    Auth::login($existingUser);
                } else {
                    // Create completely new user
                    $newUser = User::create([
                        'customer_name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                    ]);
                    Auth::login($newUser);
                }
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            // Handle the error, show a message
            dd("Failed to log in. Please try again later. " . $e->getMessage());
        }
    }
}
