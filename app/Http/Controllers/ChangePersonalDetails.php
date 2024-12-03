<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePersonalDetails extends Controller
{
    // Display the Change Personal Details form
    public function showChangePersonalDetailsForm()
    {
        return view('profile.change-personal-details');
    }

    // Handle Change Personal Details form submission
    public function updatePersonalDetails(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's personal details
        $user->name = $request->name;
        $user->email = $request->email;

        // Save the updated details
        $user->save();

        // Redirect back with a success message
        return back()->with('success', 'Your personal details have been successfully updated.');
    }
}

