<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if ($product = Product::find($productId)) {
            if ($cartItem = Cart::where(['user_id' => auth()->id(), 'product_id' => $productId])->first()) {
                $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
            } else {
                Cart::create(['user_id' => auth()->id(), 'product_id' => $productId, 'quantity' => $quantity]);
            }

            return response()->json(['message' => 'Product added to the cart']);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $productId = $request->product_id;

        if ($cartItem = Cart::where(['user_id' => auth()->id(), 'product_id' => $productId])->first()) {
            // If it is, remove the item from the cart
            $cartItem->delete();
            return response()->json(['message' => 'Product removed from the cart']);
        }

        return response()->json(['error' => 'Product not found in the cart'], 404);
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        return response()->json(['cart' => $cartItems]);
    }
}
