<?php
/********************************
Developer: Abdullah Alharbi, Robert Oros
University ID: 230046409, 230237144
********************************/
namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    /**
     * Display basket items.
     */
    public function index()
    {

        $basket = Basket::where('customer_id', Auth::id())->first();

        if (!$basket) {
            return view('basket', ['cartItems' => [], 'total' => 0]);
        }

        $cartItems = $basket->products;

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        return view('basket', compact('cartItems', 'total'));
    }
    // Basket API
    public function getBasket()
    {
        $basket = Basket::where('customer_id', Auth::id())->first();

        if (!$basket) {
            return response()->json(['cartItems' => [], 'total' => 0]);
        }

        $cartItems = $basket->products->map(function ($product) {
            $product->primary_image = $product->images->first()->url ?? null;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
                'img_url' => asset('storage/' . $product->primary_image),
                'description' => $product->description,
                'category' => $product->categories->pluck('name'), // Assuming categories relationship exists
            ];
        });

        $total = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json(['cartItems' => $cartItems, 'total' => $total]);
    }

    /**
     * Add product to basket.
     */
    public function add(Request $request, Product $product)
    {
     
        // Fetch stock for the product
        $stock = Stock::where('product_id', $product->id)->first();
      
        if (!$stock) {
            return redirect()->back()->withErrors(['error' => 'Stock information not found for this product.']);
        }

        $request->validate([
            'quantity' => 'required|numeric|min:1|max:' . $stock->quantity,
        ]);

        $basket = Basket::firstOrCreate(['customer_id' => Auth::id()]);

        $existingItem = $basket->products()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $basket->products()->updateExistingPivot($product->id, [
                'quantity' => $existingItem->pivot->quantity + $request->quantity,
            ]);
        } else {
            $basket->products()->attach($product->id, ['quantity' => $request->quantity]);
        }

        return redirect()->route('shop')->with('success', 'Product added to basket successfully!');
    }

    /**
     * Update product quantity in the basket.
     */
    public function update(Request $request, $productId)
    {
        $basket = Basket::where('customer_id', Auth::id())->firstOrFail();

        $request->validate([
            'quantity' => 'required|numeric|min:0|max:' . Stock::where('product_id', $productId)->value('quantity'),
        ]);

        if ($request->quantity == 0) {
            // Remove the product from the basket if quantity is set to zero
            $basket->products()->detach($productId);
            return response()->json([
                'success' => true,
                'message' => 'Item Removed from basket',
            ]);
        } else {
            // Update the product's quantity in the basket
            $basket->products()->updateExistingPivot($productId, ['quantity' => $request->quantity]);
            return response()->json([
                'success' => true,
                'message' => 'Basket updated successfully.',
                'updatedQuantity' => $request->quantity,
            ]);
        }
    }

    /**
     * Clear all items from the basket.
     */
    public function clear()
    {
        
        $basket = Basket::where('customer_id', Auth::id())->first();
        
        if ($basket) {
            $basket->products()->detach();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Basket cleared.',
        ]);
    }
    
    /**
     * Proceed to checkout.
     */
    public function proceedToCheckout()
    {
        return redirect()->route('checkout.show');
    }
}
