<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->
@extends('admin.layouts.admin')

@section('title', 'Order Details')

@section('header', 'Order Details')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Order #{{ $order->invoice_id }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Orders
                    </a>
                    <a href="{{ route('admin.orders.invoice', $order->invoice_id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Invoice
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Order Information -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="font-semibold text-lg mb-3">Order Information</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Order ID</p>
                            <p class="font-medium">#{{ $order->invoice_id }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="font-medium">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p>
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
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Total Amount</p>
                            <p class="font-medium">${{ number_format($order->amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="font-semibold text-lg mb-3">Customer Information</h3>

                    @if($order->customer)
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $order->customer->customer_name }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $order->customer->email }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-medium">{{ $order->customer->phone_number ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Customer Since</p>
                                <p class="font-medium">{{ $order->customer->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('admin.customers.show', $order->customer->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                View Customer Profile →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">Customer information not available</p>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-3">Order Items</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($order->invoiceOrders as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->product && $item->product->images->isNotEmpty())
                                            <img class="h-10 w-10 rounded-full object-cover mr-3"
                                                 src="{{$item->product->images->first()->url }}"
                                                 alt="{{ $item->product->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product ? $item->product->name : 'Unknown Product' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                ID: {{ $item->product ? $item->product->id : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">£ {{ number_format($item->product_cost, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">£ {{ number_format($item->product_cost * $item->quantity, 2) }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No items found for this order</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">${{ number_format($order->amount, 2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="font-semibold text-lg mb-3">Order Actions</h3>

            <!-- Flex container that holds all forms in one row -->
            <div class="flex flex-wrap items-center gap-4">

                <!-- Update Status Form -->
                <form 
                action="{{ route('admin.orders.status.update', $order->invoice_id) }}" 
                method="POST" 
                class="flex items-center gap-2"
                >
                @csrf
                <!-- Label and select on the same line -->
                <label for="status" class="text-sm font-medium text-gray-700">Change Status:</label>
                <select 
                    name="status" 
                    id="status" 
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button 
                    type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                >
                    Update Status
                </button>
                </form>

                <!-- Ship Order (if not already shipped) -->
                @if($order->status == 'paid' || $order->status == 'processing')
                <form action="{{ route('admin.orders.ship', $order->invoice_id) }}" method="POST" class="flex items-center">
                    @csrf
                    <button 
                    type="submit" 
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded"
                    >
                    Ship Order
                    </button>
                </form>
                @endif

                <!-- Cancel Order (if not delivered or cancelled) -->
                @if($order->status != 'delivered' && $order->status != 'cancelled')
                <form 
                    action="{{ route('admin.orders.cancel', $order->invoice_id) }}" 
                    method="POST" 
                    class="flex items-center"
                >
                    @csrf
                    <button 
                    type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')"
                    >
                    Cancel Order
                    </button>
                </form>
                @endif

            </div>
            </div>

        </div>
    </div>
@endsection
