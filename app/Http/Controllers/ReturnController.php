<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceOrder;

class ReturnController extends Controller
{
    /**
     * Remove multiple products from an invoice.
     *
     * The request must include a JSON payload with:
     * - invoice: the invoice id
     * - products: an array of product ids to remove from the invoice
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeProducts(Request $request)
    {
        // Validate the incoming JSON data
        $data = $request->validate([
            'invoice'  => 'required|integer|exists:invoices,invoice_id',
            'products' => 'required|array|min:1',
            'products.*' => 'required|integer'
        ]);

        $invoiceId = $data['invoice'];
        $productIds = $data['products'];

        try {
            // Wrap the deletion and update logic in a transaction
            $deletedCount = DB::transaction(function () use ($invoiceId, $productIds) {
                // Retrieve matching invoice orders for the given invoice and products
                $invoiceOrders = InvoiceOrder::where('invoice_id', $invoiceId)
                    ->whereIn('product_id', $productIds)
                    ->get();

                // If no matching records are found, throw an exception to rollback the transaction
                if ($invoiceOrders->isEmpty()) {
                    throw new \Exception('None of the specified products were found in the invoice.');
                }

                // Delete the invoice order records for the specified products
                $deletedCount = InvoiceOrder::where('invoice_id', $invoiceId)
                    ->whereIn('product_id', $productIds)
                    ->delete();

                // Check if there are any remaining invoice orders for this invoice
                $remainingOrders = InvoiceOrder::where('invoice_id', $invoiceId)->count();
                if ($remainingOrders === 0) {
                    // If no products remain, update the invoice's deleted column to true
                    Invoice::where('invoice_id', $invoiceId)->update(['deleted' => true]);
                }

                return $deletedCount;
            });
        } catch (\Exception $e) {
            // Return an error response if the transaction fails or no products are found
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }

        // Return a success message with the count of removed products
        return response()->json([
            'message' => "Successfully removed {$deletedCount} product(s) from the invoice."
        ], 200);
    }
}
