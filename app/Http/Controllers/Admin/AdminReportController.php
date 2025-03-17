<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * generate sales report.
     */
    public function salesReport(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $baseQuery = DB::table('invoices')
            ->join('invoice_orders', 'invoices.invoice_id', '=', 'invoice_orders.invoice_id')
            ->whereBetween('invoices.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $statuses = ['paid', 'pending', 'delivered'];
        $baseQuery->whereIn('invoices.status', $statuses);

        if ($period == 'daily') {
            $sales = $baseQuery->select(
                DB::raw('DATE(invoices.created_at) as date'),
                DB::raw('COUNT(DISTINCT invoices.invoice_id) as order_count'),
                DB::raw('SUM(invoice_orders.product_cost * invoice_orders.quantity) as total_amount')
            )
                ->groupBy(DB::raw('DATE(invoices.created_at)'))
                ->orderBy(DB::raw('DATE(invoices.created_at)'))
                ->get();

            $labels = $sales->pluck('date');
        } else if ($period == 'weekly') {
            $sales = $baseQuery->select(
                DB::raw('YEARWEEK(invoices.created_at) as yearweek'),
                DB::raw('MIN(DATE(invoices.created_at)) as week_start'),
                DB::raw('COUNT(DISTINCT invoices.invoice_id) as order_count'),
                DB::raw('SUM(invoice_orders.product_cost * invoice_orders.quantity) as total_amount')
            )
                ->groupBy(DB::raw('YEARWEEK(invoices.created_at)'))
                ->orderBy(DB::raw('YEARWEEK(invoices.created_at)'))
                ->get();

            $labels = $sales->pluck('week_start')->map(function($date) {
                return 'Week of ' . $date;
            });
        } else {
            $sales = $baseQuery->select(

                DB::raw('YEAR(invoices.created_at) as year'),

                DB::raw('MONTH(invoices.created_at) as month'),
                DB::raw('COUNT(DISTINCT invoices.invoice_id) as order_count'),
                DB::raw('SUM(invoice_orders.product_cost * invoice_orders.quantity) as total_amount')
            )
                ->groupBy(DB::raw('YEAR(invoices.created_at)'), DB::raw('MONTH(invoices.created_at)'))

                ->orderBy(DB::raw('YEAR(invoices.created_at)'))
                ->orderBy(DB::raw('MONTH(invoices.created_at)'))
                ->get();

            $labels = $sales->map(function($item) {

                return date('F Y', mktime(0, 0, 0, $item->month, 1, $item->year));
            });
        }

        // Chart data
        $chartData = [
            'labels' => $labels,

            'datasets' => [
                [
                    'label' => 'Sales Amount',
                    'data' => $sales->pluck('total_amount'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Order Count',
                    'data' => $sales->pluck('order_count'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1

                ]
            ]
        ];


        $totalSales = $baseQuery->sum(DB::raw('invoice_orders.product_cost * invoice_orders.quantity'));
        $totalOrders = DB::table('invoices')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereIn('status', $statuses)
            ->count();
        $averageOrderValue = $totalOrders > 0 ? ($totalSales / $totalOrders) : 0;

        return view('admin.reports.sales', compact(
            'chartData',
            'sales',
            'period',
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'averageOrderValue'
        ));
    }

    /**
     * Generate inventory report.
     */

    public function inventoryReport(Request $request)
    {
        $stockThreshold = $request->input('threshold', 10);



        $products = Product::with(['stock', 'categories'])
            ->where('deleted', 0)
            ->get();



        $outOfStock = $products->filter(function ($product) {

            return $product->stock && $product->stock->quantity == 0;

        });


        $lowStock = $products->filter(function ($product) use ($stockThreshold) {

            return $product->stock && $product->stock->quantity > 0 && $product->stock->quantity <= $stockThreshold;

        });

        $inStock = $products->filter(function ($product) use ($stockThreshold) {

            return $product->stock && $product->stock->quantity > $stockThreshold;
        });


        $totalInventoryValue = $products->sum(function ($product) {
            return $product->price * ($product->stock ? $product->stock->quantity : 0);
        });


        $topSellingProducts = DB::table('invoice_orders')

            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))

            ->groupBy('product_id')

            ->orderByDesc('total_quantity')

            ->take(10)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'product' => $product,
                    'total_quantity' => $item->total_quantity
                ];
            });

        return view('admin.reports.inventory', compact(
            'products',
            'outOfStock',
            'lowStock',
            'inStock',
            'totalInventoryValue',
            'topSellingProducts',
            'stockThreshold'
        ));
    }

    /**
     * generate customer report.
     */

    public function customerReport(Request $request)
    {

        $topCustomersBySpend = DB::table('customers')
            ->select(
                'customers.id',
                'customers.customer_name',
                'customers.email',
                'customers.phone_number',
                'customers.created_at',
                DB::raw('SUM(invoice_orders.product_cost * invoice_orders.quantity) as total_spend')
            )
            ->join('invoices', 'customers.id', '=', 'invoices.customer_id')
            ->join('invoice_orders', 'invoices.invoice_id', '=', 'invoice_orders.invoice_id')
            // Include multiple statuses to see more data
            ->whereIn('invoices.status', ['paid', 'pending', 'delivered'])
            ->groupBy(
                'customers.id',
                'customers.customer_name',
                'customers.email',
                'customers.phone_number',
                'customers.created_at'
            )
            ->orderByDesc('total_spend')
            ->take(10)
            ->get();


        $topCustomersByOrders = DB::table('customers')
            ->select(
                'customers.id',
                'customers.customer_name',
                'customers.email',
                'customers.phone_number',
                'customers.created_at',
                DB::raw('COUNT(DISTINCT invoices.invoice_id) as order_count')
            )
            ->join('invoices', 'customers.id', '=', 'invoices.customer_id')

            ->whereIn('invoices.status', ['paid', 'pending', 'delivered'])
            ->groupBy(
                'customers.id',
                'customers.customer_name',
                'customers.email',
                'customers.phone_number',
                'customers.created_at'
            )
            ->orderByDesc('order_count')
            ->take(10)
            ->get();


        $newCustomersByMonth = Customer::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as customer_count')
        )
            ->whereYear('created_at', '>=', now()->subYear()->year)
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('F Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'count' => $item->customer_count
                ];
            });


        $customerChartData = [
            'labels' => $newCustomersByMonth->pluck('month'),
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $newCustomersByMonth->pluck('count'),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        return view('admin.reports.customers', compact(
            'topCustomersBySpend',
            'topCustomersByOrders',
            'newCustomersByMonth',
            'customerChartData'
        ));
    }
}
