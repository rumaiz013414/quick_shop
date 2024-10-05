<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Tshirt;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // Handle purchasing the items in the cart
    public function purchaseCart(Request $request)
{
    $user = auth()->user(); // Ensure user is authenticated

    // Fetch the user's cart with the associated t-shirts
    $cart = Cart::where('user_id', $user->id)->with('items.tshirt')->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json(['message' => 'Cart is empty'], 400);
    }

    // Begin a transaction to ensure data integrity
    DB::beginTransaction();

    try {
        $totalPrice = 0;

        // Loop through the cart items and reduce the stock
        foreach ($cart->items as $cartItem) {
            $tshirt = $cartItem->tshirt;

            if ($tshirt->stock < $cartItem->quantity) {
                // If the requested quantity exceeds available stock, return an error
                return response()->json([
                    'message' => "Not enough stock for {$tshirt->name}"
                ], 400);
            }

            // Reduce the stock
            $tshirt->decrement('stock', $cartItem->quantity);

            // Calculate total price for this sale
            $itemTotalPrice = $tshirt->price * $cartItem->quantity;
            $totalPrice += $itemTotalPrice;

            // Log the sale in the Sale table
            Sale::create([
                'tshirt_id' => $tshirt->id,
                'quantity' => $cartItem->quantity,
                'total_price' => $itemTotalPrice,
                'user_id' => $user->id,
            ]);
        }

        // Clear the cart after purchase
        $cart->items()->delete(); // Delete all cart items

        // Commit the transaction
        DB::commit();

        return response()->json(['message' => 'Purchase completed successfully.']);
    } catch (\Exception $e) {
        // Rollback the transaction in case of any error
        DB::rollBack();
        return response()->json(['message' => 'Purchase failed. Please try again.'], 500);
    }
}
}
