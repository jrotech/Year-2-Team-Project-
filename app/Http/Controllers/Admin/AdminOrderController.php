<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
University ID: 230046409, 230222232
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceOrder;
use App\Models\Product;

class AdminOrderController extends Controller
{
    /**
     * Display a list of orders.
     */

    public function index(Request $request)
    {

        $query = Invoice::with('customer');



        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }


        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($sq) use ($search) {
                        $sq->where('customer_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }


        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }



        $query->orderBy('created_at', 'desc');

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the selected order.
     */
    public function show(Invoice $order)
    {
        $order->load(['customer', 'invoiceOrders.product.images']);

        return view('admin.orders.show', compact('order'));

    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Invoice $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,shipped,delivered,cancelled',
        ]);


        $order->status = $request->status;
        $order->save();


        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Process order shipment.
     */
    public function processShipment(Request $request, Invoice $order)
    {


        if ($order->status !== 'paid' && $order->status !== 'processing') {
            return back()->with('error', 'This order cannot be shipped in its current state.');
        }




        $order->status = 'shipped';
        $order->save();




        return back()->with('success', 'Order has been marked as shipped.');
    }

    /**
     * Cancel an order.
     */
    public function cancelOrder(Request $request, Invoice $order)
    {


        if ($order->status === 'shipped' || $order->status === 'delivered') {
            return back()->with('error', 'Orders that have been shipped or delivered cannot be cancelled.');
        }



        foreach ($order->invoiceOrders as $orderItem) {
            $product = $orderItem->product;


            if ($product->stock) {

                $product->stock->quantity += $orderItem->quantity;
                $product->stock->save();



                if ($product->stock->quantity > 0 && !$product->in_stock) {
                    $product->in_stock = true;
                    $product->save();
                }
            }
        }



        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Order has been cancelled and stock has been restored.');
    }

    /**
     * Generate invoice PDF.
     */
    public function generateInvoice(Invoice $order)
    {
        $order->load(['customer', 'invoiceOrders.product']);


        return view('admin.orders.invoice', compact('order'));
    }
}
