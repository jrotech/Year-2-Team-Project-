<?php
/********************************
Developer: Iddrisu Musah, Robert Oros
University ID: 230222232, 230237144
********************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePersonalDetails extends Controller
{
    public function showChangePersonalDetailsForm()
    {
        // Display the unified manage-profile view
        return view('manage-profile');
    }

    public function updatePersonalDetails(Request $request)
    {
        // Validate the input
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email,' . Auth::guard('customer')->id()],
        ]);

        // Get the authenticated customer
        $customer = Auth::guard('customer')->user();

        // Update customer details
        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;

        // Save the changes
        $customer->save();

        return redirect('dashboard')->with('success_personal', 'Your personal details have been successfully updated.');
    }
}
