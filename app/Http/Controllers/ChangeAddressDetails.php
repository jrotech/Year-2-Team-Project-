<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeAddressDetails extends Controller
{
    
    public function showChangeAddressForm()
    {
        return view('profile.change-address');
    }

    
    public function updateAddress(Request $request)
    {
        
        $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
        ]);

        
        $user = Auth::user();

        
        $user->street = $request->street;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;

        
        $user->save();

        return back()->with('success', 'Your address has been successfully updated.');
    }
}

