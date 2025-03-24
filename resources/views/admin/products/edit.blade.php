@extends('admin.layouts.admin')

@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Edit Product: {{ $product->name }}</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Products
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete Product
                        </button>
                    </form>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">Validation Error</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Product Details Update Form (no stock fields here) -->
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Basic Information</h4>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (£)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="6" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                               {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Images</h4>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                            @if($product->images->count() > 0)
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-32 w-full object-cover rounded">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <div class="flex space-x-2">
                                                    <label class="cursor-pointer bg-white text-gray-800 p-1 rounded">
                                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="sr-only">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500">Hover and check the trash icon to delete an image.</p>
                            @else
                                <p class="text-sm text-gray-500">No images available for this product.</p>
                            @endif
                        </div>
                        <div class="mb-6">
                            <label for="new_images" class="block text-sm font-medium text-gray-700 mb-2">Add New Images</label>
                            <input type="file" name="new_images[]" id="new_images" multiple accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">You can select multiple images.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Update Product
                    </button>
                </div>
            </form>

            <!-- Stock Management Form (placed separately) -->
            <div class="mt-10">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Stock Management</h4>
                <div class="bg-gray-50 p-4 rounded-md mb-6">
                    <h5 class="font-medium text-gray-800 mb-2">Update Stock Quantity</h5>
                    <p class="text-sm text-gray-600 mb-4">
                        Enter a positive number to add stock or a negative number to remove stock.
                    </p>
                    <form action="{{ route('admin.products.stock.update', $product->id) }}" method="POST" class="flex flex-wrap items-end gap-4">
                        @csrf
                        <div class="flex-1">
                            <label for="quantity_change" class="block text-sm font-medium text-gray-700 mb-2">Quantity Change</label>
                            <input type="number" name="quantity_change" id="quantity_change" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex-1">
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Note (Optional)</label>
                            <input type="text" name="note" id="note"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update Stock
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <p class="text-sm text-gray-700">Current Stock: {{ $product->stock ? $product->stock->quantity : 0 }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
