<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->
@extends('admin.layouts.admin')

@section('title', 'Inventory Report')
@section('header', 'Inventory Report')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Inventory Overview</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">




                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">

                    <div class="flex justify-between items-center">

                        <h3 class="text-lg font-medium text-blue-800">In Stock</h3>

                        <span class="text-2xl font-bold text-blue-800">{{ $inStock->count() }}</span>

                    </div>

                    <p class="text-blue-600 text-sm mt-1">Products with sufficient stock</p>

                </div>



                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">


                    <div class="flex justify-between items-center">

                        <h3 class="text-lg font-medium text-yellow-800">Low Stock</h3>

                        <span class="text-2xl font-bold text-yellow-800">{{ $lowStock->count() }}</span>

                    </div>

                    <p class="text-yellow-600 text-sm mt-1">Products below threshold ({{ $stockThreshold }} units)</p>

                </div>


                <div class="bg-red-50 rounded-lg p-4 border border-red-200">


                    <div class="flex justify-between items-center">

                        <h3 class="text-lg font-medium text-red-800">Out of Stock</h3>


                        <span class="text-2xl font-bold text-red-800">{{ $outOfStock->count() }}</span>

                    </div>

                    <p class="text-red-600 text-sm mt-1">Products with no stock available</p>


                </div>


            </div>


            <div class="bg-green-50 rounded-lg p-4 border border-green-200 mb-6">

                <div class="flex justify-between items-center">

                    <h3 class="text-lg font-medium text-green-800">Total Inventory Value</h3>

                    <span class="text-2xl font-bold text-green-800">${{ number_format($totalInventoryValue, 2) }}</span>

                </div>

                <p class="text-green-600 text-sm mt-1">Based on current stock levels and product prices</p>


            </div>




            <form action="{{ route('admin.reports.inventory') }}" method="GET" class="mb-6">

                <div class="flex items-center space-x-4">

                    <div class="flex-1">

                        <label for="threshold" class="block text-sm font-medium text-gray-700 mb-1">Stock Threshold</label>


                        <input type="number" id="threshold" name="threshold" value="{{ $stockThreshold }}" min="1" max="100"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    </div>

                    <div class="pt-6">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply
                        </button>
                    </div>

                </div>


            </form>


        </div>


    </div>

    <!-- Low Stock & Out of Stock Products -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Low Stock & Out of Stock Products</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>


                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($lowStock->merge($outOfStock)->sortBy('stock.quantity') as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if ($product->images->isNotEmpty())
                                        <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{$product->images->first()->url}}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 mr-3 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div>

                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>

                                        <div class="text-sm text-gray-500">ID: {{ $product->id }}</div>

                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm text-gray-900">{{ $product->stock ? $product->stock->quantity : 0 }}</div>

                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm text-gray-900">${{ number_format($product->price, 2) }}</div>

                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">


                                <div class="text-sm text-gray-900">${{ number_format(($product->stock ? $product->stock->quantity : 0) * $product->price, 2) }}</div>

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if(!$product->stock || $product->stock->quantity == 0) bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        @if(!$product->stock || $product->stock->quantity == 0)
                                            Out of Stock
                                        @else
                                            Low Stock
                                        @endif
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Update Stock</a>
                            </td>
                        </tr>
                    @empty


                        <tr>

                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No low stock or out of stock products found</td>

                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Top Selling Products</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>


                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold Quantity</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">


                    @forelse ($topSellingProducts as $item)

                        <tr>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="flex items-center">

                                    @if ($item['product']->images->isNotEmpty())

                                        <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{$item['product']->images->first()->url}}" alt="{{ $item['product']->name }}">

                                    @else

                                        <div class="h-10 w-10 rounded-full bg-gray-200 mr-3 flex items-center justify-center">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                            </svg>
                                        </div>
                                    @endif
                                    <div>

                                        <div class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</div>


                                        <div class="text-sm text-gray-500">ID: {{ $item['product']->id }}</div>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm text-gray-900">{{ number_format($item['total_quantity']) }}</div>

                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm text-gray-900">{{ $item['product']->stock ? $item['product']->stock->quantity : 0 }}</div>

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm text-gray-900">${{ number_format($item['product']->price, 2) }}</div>

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                <a href="{{ route('admin.products.edit', $item['product']->id) }}" class="text-indigo-600 hover:text-indigo-900">View Product</a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No sales data available</td>


                        </tr>

                    @endforelse

                    </tbody>
                </table>
            </div>



            
        </div>
    </div>
@endsection
