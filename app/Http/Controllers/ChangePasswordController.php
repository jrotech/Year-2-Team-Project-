<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ChangePasswordController extends Controller
{
    // Display the Change Password form
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    // Handle Change Password form submission
    public function updatePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'different:current_password'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        // Check if the current password matches the logged-in user's password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect with a success message
        return back()->with('success', 'Your password has been successfully updated.');
    }
}