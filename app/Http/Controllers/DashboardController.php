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
        $customer = Customer::findOrFail(Auth::id());
        $invoices = Invoice::with(['invoiceOrders.product.images'])->where('customer_id', '=', $customer->id)->get();
      
        return view('orders', compact('invoices'));
    }

    public function apiCategoryLastProduct()
    {
        // Fetch the last invoice (by invoice_id)
        $lastInvoice = Invoice::with([
            'invoiceOrders.product.categories', // Eager load product and categories to reduce queries
        ])
        ->orderBy('invoice_id', 'desc')
        ->first();
    
        // Handle case: No invoices found
        if (!$lastInvoice) {
            return response()->json([
                'success' => false,
                'message' => 'No invoices found.'
            ], 404);
        }

        $lastInvoiceOrder = $lastInvoice->invoiceOrders->last();

        if (!$lastInvoiceOrder) {
            return response()->json([
                'success' => false,
                'message' => 'No invoice orders found for the last invoice.'
            ], 404);
        }
    
        
        $lastProduct = $lastInvoiceOrder->product;
    
        
        if (!$lastProduct) {
            return response()->json([
                'success' => false,
                'message' => 'No product found for the last invoice order.'
            ], 404);
        }
    
        $category = $lastProduct->categories->first();
    
        if (!$category) {
            return response()->json([
                'success' => true,
                'last_product' => $lastProduct,
                'related_products' => [] // No category means no related products
            ]);
        }
    
        // Fetch up to 3 other products from the same category (exclude the last product)
        $relatedProducts = $category->products()
            ->where('products.id', '!=', $lastProduct->id)
            ->take(3)
            ->get();
    
        // Return JSON with last product and related products
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
