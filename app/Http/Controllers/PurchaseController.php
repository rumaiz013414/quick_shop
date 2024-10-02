<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // Handle purchasing the items in the cart
    public function purchaseCart()
    {
        $user = auth()->user();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $user->id)->with('items.tshirt')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // Begin a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Loop through the cart items and reduce the stock
            foreach ($cart->items as $cartItem) {
                $tshirt = $cartItem->tshirt;

                if ($tshirt->stock < $cartItem->quantity) {
                    // If the requested quantity exceeds available stock, throw an error
                    return response()->json([
                        'message' => "Not enough stocks : {$tshirt->name}"
                    ], 400);
                }

                // Reduce the stock
                $tshirt->decrement('stock', $cartItem->quantity);
            }

            // Clear the cart after purchase
            $cart->items()->delete();

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Purchase completed successfully.']);
        } catch (\Exception $e) {
            // Rollback in case of any error
            DB::rollBack();
            return response()->json(['message' => 'Purchase failed. Please try again.'], 500);
        }
    }
    public function showDashboard()
{
    $user = auth()->user();

    // Fetch the user's purchases
    $purchases = DB::table('purchases')
        ->where('user_id', $user->id)
        ->get();

    // Fetch additional analytics data (already present)
    $totalTshirts = Tshirt::count();
    $totalStock = Tshirt::sum('stock');
    $averagePrice = Tshirt::avg('price');
    $mostStockedTshirt = Tshirt::orderBy('stock', 'desc')->first();
    $leastStockedTshirt = Tshirt::orderBy('stock', 'asc')->first();

    return view('dashboard', [
        'purchases' => $purchases,
        'totalTshirts' => $totalTshirts,
        'totalStock' => $totalStock,
        'averagePrice' => $averagePrice,
        'mostStockedTshirt' => $mostStockedTshirt,
        'leastStockedTshirt' => $leastStockedTshirt
    ]);
}

}
