<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'different:current_password'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        // Get the authenticated customer
        $customer = Auth::guard('customer')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $customer->password = Hash::make($request->new_password);
        $customer->save();

        return redirect('dashboard')->with('success_password', 'Your password has been successfully updated.');
    }
}
