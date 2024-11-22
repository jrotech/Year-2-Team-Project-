<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
Function: This controller adds the basket feature
 ********************************/
namespace App\Http\Controllers;

use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    // display basket
    public function index()
    {
        $cartItems = BasketItem::with('product')
            ->where('customer_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }
    //add to the basket
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $cartItem = BasketItem::where('customer_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            BasketItem::create([
                'customer_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product added to cart successfully!');
    }

    // update the basket
    public function update(Request $request, BasketItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    //remove from the basket
    public function remove(BasketItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // clear the basket
    public function clear()
    {
        BasketItem::where('customer_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
