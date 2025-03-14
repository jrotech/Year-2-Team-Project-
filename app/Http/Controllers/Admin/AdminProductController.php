<?php
/********************************
Developer: [Your Name]
University ID: [Your ID]
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * disply a list of products.
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
     * dipsly the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('delete', 0)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * store a new created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:10000',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'in_stock' => 'required|boolean',
            'stock_quantity' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'in_stock' => $request->in_stock,
            'deleted' => 0,
        ]);

        Stock::create([
            'product_id' => $product->id,
            'quantity' => $request->stock_quantity,
        ]);

        $product->categories()->attach($request->categories);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                Image::create([
                    'product_id' => $product->id,
                    'url' => $path,
                    'alt' => $product->name,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * display the form for editing the selected product.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'images', 'stock']);
        $categories = Category::where('delete', 0)->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:10000',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'in_stock' => 'required|boolean',
            'stock_quantity' => 'required|numeric|min:0',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'in_stock' => $request->in_stock,
        ]);

        if ($product->stock) {
            $product->stock->update(['quantity' => $request->stock_quantity]);
        } else {
            Stock::create([
                'product_id' => $product->id,
                'quantity' => $request->stock_quantity,
            ]);
        }

        $product->categories()->sync($request->categories);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('products', 'public');

                Image::create([
                    'product_id' => $product->id,
                    'url' => $path,
                    'alt' => $product->name,
                ]);
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = Image::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    Storage::disk('public')->delete($image->url);
                    $image->delete();
                }
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully');
    }

    /**
     * remove the selected product from storage.
     */
    public function destroy(Product $product)
    {

        if ($product->invoiceOrders()->count() > 0) {
            $product->update(['deleted' => 1]);
            return redirect()->route('admin.products.index')
                ->with('success', 'Product has been marked as deleted.');
        }


        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->url);
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
     * update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity_change' => 'required|integer',
            'note' => 'nullable|string|max:255',
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
