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

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }


    public function callback(){
        try {
            $user = Socialite::driver('google')->user();

            //check if the user exists
            $findUser = User::where('email', $user->getEmail())->first();

            // If the user already exists log them in
            if ($findUser) {
                // if Google ID is not already set, set a new one
                if (!$findUser->google_id) {
                    $findUser->google_id = $user->getId();
                    $findUser->save();
                }

                Auth::login($findUser);
                return redirect()->intended('/');
            } else {
                // If user does not exist, create a new one
                $newUser = User::create([
                    'customer_name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),

                ]);

                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            // Handle the error, show a message
            dd("Failed to log in. Please try again later. " . $e->getMessage());
        }
    }

}
