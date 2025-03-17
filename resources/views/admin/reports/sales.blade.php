<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->
@extends('admin.layouts.admin')

@section('title', 'Sales Report')
@section('header', 'Sales Report')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Sales Report</h2>

            <!-- Filters -->
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Report Period</label>
                        <select name="period" id="period" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                            Generate Report
                        </button>
                    </div>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Summary Cards -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-blue-800">Total Sales</h3>
                        <span class="text-2xl font-bold text-blue-800">${{ number_format($totalSales, 2) }}</span>
                    </div>
                    <p class="text-blue-600 text-sm mt-1">Total revenue for the period</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-green-800">Total Orders</h3>
                        <span class="text-2xl font-bold text-green-800">{{ number_format($totalOrders) }}</span>
                    </div>
                    <p class="text-green-600 text-sm mt-1">Number of orders for the period</p>
                </div>

                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-purple-800">Average Order Value</h3>
                        <span class="text-2xl font-bold text-purple-800">${{ number_format($averageOrderValue, 2) }}</span>
                    </div>
                    <p class="text-purple-600 text-sm mt-1">Average value per order</p>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="h-80 mb-6">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Sales Details</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sales</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Order</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    @if($period == 'daily')
                                        {{ $sale->date ?? '' }}
                                    @elseif($period == 'weekly')
                                        Week of {{ $sale->week_start ?? '' }}
                                    @else
                                        {{ date('F Y', mktime(0, 0, 0, $sale->month ?? 1, 1, $sale->year ?? 2000)) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($sale->order_count) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($sale->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    ${{ number_format($sale->order_count > 0 ? $sale->total_amount / $sale->order_count : 0, 2) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No sales data available for the selected period</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Sales Amount',
                        data: {!! json_encode($chartData['datasets'][0]['data'] ?? []) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Order Count',
                        data: {!! json_encode($chartData['datasets'][1]['data'] ?? []) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Sales Amount ($)'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        type: 'linear',
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Order Count'
                        }
                    }
                }
            }
        });
    </script>
@endsection
