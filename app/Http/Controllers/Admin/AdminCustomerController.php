<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
University ID: 230046409, 230222232
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    /**
     * Display a list of customers.
     */

    public function index(Request $request)
    {
        $query = Customer::query();



        if ($request->has('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }


        $query->orderBy('customer_name');

        $customers = $query->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * display form for creating a new customer.
     */
    public function create()
    {

        return view('admin.customers.create');
    }

    /**
     * Store a new created customer in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:15',
            'password' => 'required|min:8|confirmed',
        ]);


        Customer::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'email_confirmed' => true, // Assuming admin-created accounts are pre-confirmed
        ]);


        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully');
    }

    /**
     * display the selected customer.
     */

    public function show(Customer $customer)
    {

        $customer->load(['invoices' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('admin.customers.show', compact('customer'));

    }

    /**
     * Show the form for editing the specified customer.
     */

    public function edit(Customer $customer)
    {

        return view('admin.customers.edit', compact('customer'));

    }

    /**
     * update the chosen  customer in storage.
     */

    public function update(Request $request, Customer $customer)
    {

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:15',
            'password' => 'nullable|min:8|confirmed',
        ]);


        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;


        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }


        $customer->save();

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully');
    }

    /**
     * remove the specified customer from storage.
     */

    public function destroy(Customer $customer)
    {

        
        if ($customer->invoices()->count() > 0) {
            return back()->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully');
    }
}
