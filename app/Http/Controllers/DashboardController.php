<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

    public function dashboard()
    {
        $customer = Customer::findOrFail(Auth::id());

    // Fetch all invoices for the authenticated customer
    $invoices = Invoice::with(['invoiceOrders.product.images'])
    ->where('customer_id', $customer->id)
    ->get()
    ->map(function ($invoice) {
        $invoice->primary_img = $invoice->invoiceOrders->map(function ($order) {
            return $order->product->images->first()?->url ?? null; // Fetch the first image URL or null if not available
        })->first(); 
        return $invoice;
    });
    return view('dashboard', [
        'customer' => $customer,
        'invoices' => $invoices,
    ]);
    }

    public function orders()
    {
        return view('orders');
    }



    public function order($id)
    {
        return view('order', compact('id'));
    }
}
