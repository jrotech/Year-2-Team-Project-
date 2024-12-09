<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
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
        $customer = Customer::findOrFail(Auth::id());
        $invoices = Invoice::with(['invoiceOrders.product.images'])->where('customer_id', '=', $customer->id)->get();

        return view('orders', compact('invoices'));
    }


    public function apiCategoryLastProduct()
    {
        // Get the currently authenticated customer
        $customer = Customer::findOrFail(Auth::id());

        // Ensure the customer is logged in
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated.',
            ], 401);
        }

        
        $lastInvoice = Invoice::where('customer_id', $customer->id)
            ->with(['invoiceOrders.product.categories']) // Eager load product and categories
            ->orderBy('invoice_id', 'desc')
            ->first();


        if (!$lastInvoice) {
            return response()->json([
                'success' => false,
                'message' => 'No invoices found for this customer.',
            ], 404);
        }

       
        $lastProduct = $lastInvoice->invoiceOrders->first()?->product;

        
        if (!$lastProduct) {
            return response()->json([
                'success' => false,
                'message' => 'No products found in the last invoice.',
            ], 404);
        }

        
        $relatedProducts = Product::whereHas('categories', function ($query) use ($lastProduct) {
            $query->whereIn('categories.id', $lastProduct->categories->pluck('id'));
        })
            ->where('id', '!=', $lastProduct->id) // Exclude the last product itself
            ->limit(5)
            ->get();

        // Return response with the last product and related products
        return response()->json([
            'success' => true,
            'last_product' => $lastProduct,
            'related_products' => $relatedProducts,
        ]);
    }

    public function order($id)
    {
        $invoice = Invoice::with(['invoiceOrders.product.images'])->where('invoice_id', '=', $id)->first();

        return view('order', compact('invoice'));
    }
}
