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
        $invoices = Invoice::with([
            'invoiceOrders.product.images' // Ensure products and their images are loaded
        ])
        ->where('customer_id', $customer->id)
        ->get();
        // Add primary_img to each product inside invoiceOrders
        $invoices->each(function ($invoice) {
            $invoice->invoiceOrders->each(function ($order) {
                $order->product->primary_img = $order->product->images->first()?->url ?? null;
            });
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
