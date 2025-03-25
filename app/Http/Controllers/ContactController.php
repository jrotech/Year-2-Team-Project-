<?php
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }
    public function contact()
    {
        return view('contact');
    }
    public function submit(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'subject'      => 'required|string|max:255',
            'email'        => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'message'      => 'required|string',
        ]);


        // Store data in the database (ensure you have a corresponding migration & model)
        Contact::create($validatedData);

        return response()->json(['message' => 'Contact submitted successfully']);
    }
}
