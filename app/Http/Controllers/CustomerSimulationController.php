<?php
/********************************
Developer: Your Name
Description: Simulates a Customer record for an admin.
********************************/
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerSimulationController extends Controller
{
    /**
     * Retrieve (or create) a Customer record based on the currently authenticated admin.
     *
     * @return \App\Models\Customer|null
     */
    public function simulate()
    {
        // Check if an admin is logged in via the admin guard.
        if (!Auth::guard('admin')->check()) {
            return null;
        }

        $admin = Auth::guard('admin')->user();

        // Attempt to find a customer with the same email.
        // If one doesn't exist, create a new Customer record.
        $customer = Customer::firstOrCreate(
            ['email' => $admin->email],
            [
                'customer_name'     => "Admin",
                // Set a default password (you may change or leave this field depending on your requirements).
                'password' => bcrypt('defaultpassword'),
                // You can set other default fields as needed.
            ]
        );

        return $customer;
    }
}
