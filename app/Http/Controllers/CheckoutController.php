<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller adds the checkout feature
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
        $cartItems = Basket::with('product')
            ->where('customer_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your basket is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'delivery_option' => 'required|in:Delivery,Pick up',
        ]);

        $cartItems = Basket::with('product')
            ->where('customer_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your basket is empty!');
        }

        try {
            DB::beginTransaction();


            $invoice = new Invoice();
            $invoice->date = now();
            $invoice->customer_id = Auth::id();
            $invoice->invoice_number = $this->generateInvoiceNumber();
            $invoice->delivery_option = $request->delivery_option;
            $invoice->status = 'Received';


            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            $invoice->invoice_amount = $totalAmount;

            $invoice->save();


            foreach ($cartItems as $item) {
                InvoiceOrder::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item->product_id,
                    'product_cost' => $item->product->price,
                    'quantity' => $item->quantity
                ]);


                $item->product->decrement('stock', $item->quantity);
            }


            Basket::where('customer_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('cart.index')
                ->with('success', 'Order placed successfully! Order number: ' . $invoice->invoice_number);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Checkout Error: ' . $e->getMessage());


            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }


    private function generateInvoiceNumber()
    {

        $lastInvoice = Invoice::orderBy('invoice_number', 'desc')
            ->first();

       
        return $lastInvoice ? $lastInvoice->invoice_number + 1 : 1000;
    }
}
