<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Tshirt;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add a T-shirt to the cart
    public function addToCart(Request $request, Tshirt $tshirt)
    {
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Fetch the authenticated user
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Get or create the cart
    $cart = Cart::firstOrCreate(['user_id' => $user->id]);

    // Find if the item is already in the cart
    $cartItem = CartItem::where('cart_id', $cart->id)
                        ->where('tshirt_id', $tshirt->id)
                        ->first();

    if ($cartItem) {
        $cartItem->update(['quantity' => $cartItem->quantity + $validated['quantity']]);
    } else {
        CartItem::create([
            'cart_id' => $cart->id,
            'tshirt_id' => $tshirt->id,
            'quantity' => $validated['quantity'],
        ]);
    }

    return response()->json(['message' => 'Product added to cart successfully.']);
    }


    // View all items in the user's cart
    public function viewCart()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.tshirt')->first();

        return response()->json($cart ? $cart->items : []);
    }

    // Remove an item from the cart
    public function removeFromCart(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart successfully.']);
    }

    // Update quantity of an item in the cart
    public function updateCartItem(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart item updated successfully.']);
    }

    // Clear the cart
    public function clearCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json(['message' => 'Cart cleared successfully.']);
    }
}
