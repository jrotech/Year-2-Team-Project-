<?php
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Replace with your admin email
        $adminEmail = 'admin@business.com';

        Mail::raw("You have received a new contact request:\n\nName: {$validated['name']}\nEmail: {$validated['email']}\nMessage: {$validated['message']}", function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                ->subject('New Contact Request');
        });

        
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
