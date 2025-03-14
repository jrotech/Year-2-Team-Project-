<!-- resources/views/admin/orders/invoice.blade.php -->
@extends('admin.layouts.admin')

@section('title', 'Invoice #' . $order->invoice_id)
@section('header', 'Invoice #' . $order->invoice_id)

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Invoice #{{ $order->invoice_id }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.orders.show', $order->invoice_id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Order
                    </a>
                    <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Print Invoice
                    </button>
                </div>
            </div>

            <div class="border-t border-b border-gray-200 py-4 mb-6 print:border-none">
                <div class="flex justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Company Information</h3>
                        <p class="text-gray-700">{{ config('app.name', 'E-Commerce Store') }}</p>
                        <p class="text-gray-700">123 Store Street</p>
                        <p class="text-gray-700">Store City, ST 12345</p>
                        <p class="text-gray-700">Email: store@example.com</p>
                    </div>

                    <div class="text-right">
                        <h3 class="font-semibold text-lg mb-2">Invoice Details</h3>
                        <p class="text-gray-700"><span class="font-medium">Invoice Number:</span> #{{ $order->invoice_id }}</p>
                        <p class="text-gray-700"><span class="font-medium">Date:</span> {{ $order->created_at->format('M d, Y') }}</p>
                        <p class="text-gray-700"><span class="font-medium">Status:</span> {{ ucfirst($order->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-200 py-4 mb-6 print:border-none">
                <h3 class="font-semibold text-lg mb-2">Customer Information</h3>

                @if($order->customer)
                    <p class="text-gray-700"><span class="font-medium">Name:</span> {{ $order->customer->customer_name }}</p>
                    <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $order->customer->email }}</p>
                    <p class="text-gray-700"><span class="font-medium">Phone:</span> {{ $order->customer->phone_number ?? 'N/A' }}</p>

                    @if($order->address)
                        <p class="text-gray-700"><span class="font-medium">Shipping Address:</span></p>
                        <p class="text-gray-700">{{ $order->address }}</p>
                        <p class="text-gray-700">{{ $order->postcode ?? '' }}</p>
                    @endif
                @else
                    <p class="text-gray-700">Customer information not available</p>
                @endif
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Order Items</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 print:bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:text-black print:font-bold">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:text-black print:font-bold">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:text-black print:font-bold">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:text-black print:font-bold">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @php $subtotal = 0; @endphp
                        @forelse($order->invoiceOrders as $item)
                            @php
                                $itemTotal = $item->product_cost * $item->quantity;
                                $subtotal += $itemTotal;
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $item->product ? $item->product->name : 'Unknown Product' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($item->product_cost, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($itemTotal, 2) }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No items found for this order</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Subtotal:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Shipping:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                ${{ number_format($order->delivery_option == 'express' ? 10.00 : 5.00, 2) }}
                            </td>
                        </tr>
                        <tr class="bg-gray-50 print:bg-white">
                            <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">
                                ${{ number_format($subtotal + ($order->delivery_option == 'express' ? 10.00 : 5.00), 2) }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 print:border-none">
                <h3 class="font-semibold text-lg mb-2">Payment Information</h3>
                @if($order->payments)
                    <p class="text-gray-700"><span class="font-medium">Payment Method:</span> {{ ucfirst($order->payments->type ?? 'Not specified') }}</p>
                    <p class="text-gray-700"><span class="font-medium">Payment Date:</span> {{ $order->payments ? $order->payments->created_at->format('M d, Y') : 'N/A' }}</p>
                    <p class="text-gray-700"><span class="font-medium">Payment Status:</span> {{ ucfirst($order->status) }}</p>
                @else
                    <p class="text-gray-700">Payment information not available</p>
                @endif
            </div>

            <div class="mt-8 text-center text-gray-600 print:text-gray-700">
                <p>Thank you for your business!</p>
                <p class="mt-1">If you have any questions about this invoice, please contact our customer support.</p>
            </div>
        </div>
    </div>

    <style type="text/css" media="print">
        @page { size: portrait; margin: 2cm; }
        body { font-family: Arial, sans-serif; }
        nav, button, .no-print { display: none !important; }
        .print\:hidden { display: none !important; }
        .print\:border-none { border: none !important; }
        .print\:bg-white { background-color: white !important; }
        .print\:text-black { color: black !important; }
        .print\:font-bold { font-weight: bold !important; }
    </style>
@endsection
