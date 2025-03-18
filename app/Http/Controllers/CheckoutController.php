<?php
/********************************
Developer: Abdullah Alharbi, Robert Oros
University ID: 230046409, 230237144 
********************************/
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceOrder;
use App\Models\Basket;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $basket = Basket::with('products') // Load related products
            ->where('customer_id', Auth::id())
            ->first(); // Use first() since there should only be one basket

        if (!$basket) {
            return redirect()->route('basket')
                ->with('error', 'Your basket is empty!');
        }

        // Calculate the total price of products in the basket
        $total = $basket->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity; // Use pivot to get the quantity
        });

        return view('checkout', compact('basket', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
        ]);

        $cartItems = Basket::with('products')
            ->where('customer_id', Auth::id())
            ->first();

        if (!$cartItems || $cartItems->products->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your basket is empty.'], 400);
        }

        try {
            DB::beginTransaction();

            // Create Invoice
            $invoice = new Invoice();
            $invoice->customer_id = Auth::id();
            $invoice->address = $request->address;
            $invoice->postcode = $request->postcode;
            $invoice->amount = $cartItems->products->sum(function ($product) {
                return $product->price * $product->pivot->quantity;
            });
            $invoice->status = 'pending';
            $invoice->save();

            // Add Items to InvoiceOrder
            foreach ($cartItems->products as $product) {
                InvoiceOrder::create([
                    'invoice_id' => rand(10,100000),
                    'product_id' => $product->id,
                    'product_cost' => $product->price,
                    'quantity' => $product->pivot->quantity,
                ]);

                // Decrement stock
                if ($product->stock) { // Check if stock relation exists
                    $product->stock->decrement('quantity', $product->pivot->quantity ?? 0);
                } else {
                    throw new Exception("Stock entry not found for product ID: {$product->id}");
                }
            }
            
            // Clear Basket
            $cartItems->products()->detach();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order created successfully!', 'invoice_id' => $invoice->id], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error processing order. Please try again.'], 500);
        }
    }
}
