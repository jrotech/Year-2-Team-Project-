<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
University ID: 230046409, 230222232
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceOrder;

class AdminDashboardController extends Controller
{
    public function index()
    {
        //

        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalOrders = Invoice::count();

        //
        $totalRevenue = InvoiceOrder::join('invoices', 'invoice_orders.invoice_id', '=', 'invoices.invoice_id')
            ->whereIn('invoices.status', ['paid', 'pending', 'delivered'])
            ->sum(DB::raw('product_cost * quantity'));


        $recentOrders = Invoice::with(['customer', 'invoiceOrders'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                // Calculate the total amount for each order
                $order->amount = $order->invoiceOrders->sum(function ($item) {
                    return $item->product_cost * $item->quantity;
                });
                return $order;
            });



        $lowStockProducts = Product::with('stock')
            ->whereHas('stock', function ($query) {
                $query->where('quantity', '<', 10);
            })
            ->take(5)
            ->get();



        $monthlySales = DB::table('invoices')
            ->join('invoice_orders', 'invoices.invoice_id', '=', 'invoice_orders.invoice_id')
            ->selectRaw('YEAR(invoices.created_at) as year, MONTH(invoices.created_at) as month, SUM(invoice_orders.product_cost * invoice_orders.quantity) as total')
            ->whereIn('invoices.status', ['paid', 'pending', 'delivered'])
            ->whereYear('invoices.created_at', date('Y'))
            ->groupByRaw('YEAR(invoices.created_at), MONTH(invoices.created_at)')
            ->orderByRaw('YEAR(invoices.created_at) ASC, MONTH(invoices.created_at) ASC')
            ->get();


        $chartData = [
            'labels' => [],
            'data' => []
        ];

        foreach ($monthlySales as $sale) {
            $monthName = date('F', mktime(0, 0, 0, $sale->month, 1));
            $chartData['labels'][] = $monthName;
            $chartData['data'][] = $sale->total;
        }

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts',
            'chartData'
        ));
    }

    public function profile()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.profile', compact('user'));
    }
}
