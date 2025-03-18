<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->
@extends('admin.layouts.admin')

@section('title', 'Orders')

@section('header', 'Orders')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Order Management</h3>
            </div>


            <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Order ID or Customer"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-4 flex">
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Reset
                        </a>
                    </div>
                </div>
            </form>


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    #{{ $order->invoice_id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $order->customer->customer_name ?? 'Unknown' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $order->customer->email ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($order->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'paid') bg-green-100 text-green-800
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order->invoice_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    View
                                </a>

                                @if($order->status == 'pending')
                                    <form action="{{ route('admin.orders.status.update', $order->invoice_id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 mr-3">
                                            Process
                                        </button>
                                    </form>
                                @endif

                                @if($order->status == 'paid' || $order->status == 'processing')
                                    <form action="{{ route('admin.orders.ship', $order->invoice_id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:text-purple-900 mr-3">
                                            Ship
                                        </button>
                                    </form>
                                @endif

                                @if($order->status != 'delivered' && $order->status != 'cancelled')
                                    <form action="{{ route('admin.orders.cancel', $order->invoice_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
