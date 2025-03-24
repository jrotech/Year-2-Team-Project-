<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Image;

class AdminProductController extends Controller
{
    /**
     * Display a list of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'images', 'stock']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->has('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('in_stock', 1);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('in_stock', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->whereHas('stock', function ($q) {
                    $q->where('quantity', '<', 10)->where('quantity', '>', 0);
                });
            }
        }

        $products = $query->orderBy('name')->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Display the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('delete', 0)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a new created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:50',
            'price'          => 'required|numeric|min:0',
            'description'    => 'required|string|max:10000',
            'categories'     => 'required|array',
            'categories.*'   => 'exists:categories,id',
            'in_stock'       => 'required|boolean',
            'stock_quantity' => 'required|numeric|min:0',
            // Validate that images is a string (list of URLs)
            'images'         => 'required|string',
        ]);

        // Create the product record.
        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'in_stock'    => $request->in_stock,
            'deleted'     => 0,
        ]);

        // Create the stock record.
        Stock::create([
            'product_id' => $product->id,
            'quantity'   => $request->stock_quantity,
        ]);

        // Attach the selected categories.
        $product->categories()->attach($request->categories);

        // Create entries in specialized product tables based on category names.
        // We assume the category names are exactly "CPU", "GPU", etc.
        if ($cpuCategory = Category::where('name', 'CPU')->first()) {
            if (in_array($cpuCategory->id, $request->categories)) {
                \App\Models\CPUProduct::create(['product_id' => $product->id]);
            }
        }
        if ($gpuCategory = Category::where('name', 'GPU')->first()) {
            if (in_array($gpuCategory->id, $request->categories)) {
                \App\Models\GPUProduct::create(['product_id' => $product->id]);
            }
        }
        if ($motherboardCategory = Category::where('name', 'Motherboard')->first()) {
            if (in_array($motherboardCategory->id, $request->categories)) {
                \App\Models\MotherboardProduct::create(['product_id' => $product->id]);
            }
        }
        if ($psuCategory = Category::where('name', 'PSU')->first()) {
            if (in_array($psuCategory->id, $request->categories)) {
                \App\Models\PSUProduct::create(['product_id' => $product->id]);
            }
        }
        if ($ramCategory = Category::where('name', 'RAM')->first()) {
            if (in_array($ramCategory->id, $request->categories)) {
                \App\Models\RAMProduct::create(['product_id' => $product->id]);
            }
        }
        if ($storageCategory = Category::where('name', 'Storage')->first()) {
            if (in_array($storageCategory->id, $request->categories)) {
                \App\Models\StorageProduct::create(['product_id' => $product->id]);
            }
        }
        if ($coolerCategory = Category::where('name', 'Cooler')->first()) {
            if (in_array($coolerCategory->id, $request->categories)) {
                \App\Models\CoolerProduct::create(['product_id' => $product->id]);
            }
        }

        // Process the image URLs.
        // We assume the admin entered one or more URLs separated by commas or newlines.
        $imageUrls = preg_split('/[\r\n,]+/', $request->images);
        foreach ($imageUrls as $url) {
            $trimmedUrl = trim($url);
            if (!empty($trimmedUrl)) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $trimmedUrl,
                    'alt'        => $product->name,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully');
    }

    /**
     * Display the form for editing the selected product.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'images', 'stock']);
        $categories = Category::where('delete', 0)->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required|string|max:50',
            'price'        => 'required|numeric|min:0',
            'description'  => 'required|string|max:10000',
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            // Stock is updated separately via updateStock()
        ]);

        $product->categories()->sync($request->categories);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('products', 'public');
                // Instead of deleting files, we simply store the URL (if needed, adjust this logic)
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $path,
                    'alt'        => $product->name,
                ]);
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = Image::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    // No Storage deletion since images are URLs
                    $image->delete();
                }
            }
        }

        return redirect()->route('admin.products.edit', $product)
                         ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the selected product from storage.
     */
    public function destroy(Product $product)
    {
        // Removed invoiceOrders() check since that relation is undefined.

        // Delete associated image records (no file deletion needed)
        foreach ($product->images as $image) {
            $image->delete();
        }

        if ($product->stock) {
            $product->stock->delete();
        }
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product has been permanently deleted.');
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity_change' => 'required|integer',
            'note'            => 'nullable|string|max:255',
        ]);
        $stock = $product->stock ?? Stock::create(['product_id' => $product->id, 'quantity' => 0]);

        $newQuantity = $stock->quantity + $request->quantity_change;

        if ($newQuantity < 0) {
            return back()->with('error', 'Stock quantity cannot be negative.');
        }

        $stock->quantity = $newQuantity;
        $stock->save();
        $product->in_stock = ($newQuantity > 0);
        $product->save();

        return back()->with('success', 'Stock updated successfully.');
    }
}
