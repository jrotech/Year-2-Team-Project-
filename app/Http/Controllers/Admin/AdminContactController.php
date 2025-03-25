<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class AdminContactController extends Controller
{
    public function contacts()
    {
        // Retrieve all contact forms from the database
        $contacts = Contact::all();

        // Return the view with the payload of contacts
        return view('admin.contact.index', compact('contacts'));
    }
}
