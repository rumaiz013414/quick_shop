<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtController extends Controller
{
    // Get all t-shirts
    public function index()
    {
        $tshirts = Tshirt::all();
        return response()->json($tshirts);
    }
    
    public function webindex()
    {
        $tshirts = Tshirt::all();
        return view('tshirts.index', compact('tshirts'));  
    }

    // Get a single t-shirt by ID
    public function show(Tshirt $tshirt)
    {
        return response()->json($tshirt);
    }
     // Add T-shirt to Cart with quantity
     public function addToCart(Request $request, Tshirt $tshirt)
     {
         $request->validate([
             'quantity' => 'required|integer|min:1',
         ]);
 
         $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
 
         $cartItem = CartItem::where('cart_id', $cart->id)
                             ->where('tshirt_id', $tshirt->id)
                             ->first();
 
         if ($cartItem) {
             $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
         } else {
             CartItem::create([
                 'cart_id' => $cart->id,
                 'tshirt_id' => $tshirt->id,
                 'quantity' => $request->quantity,
             ]);
         }
 
         return response()->json(['message' => 'Product added to cart successfully.']);
     }
     // Fetch all items in the user's cart
    public function viewCart()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.tshirt')->first();
        return response()->json($cart ? $cart->items : []);
    }
    // Create a new t-shirt
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
            'image' => 'required|string|max:5000',
        ]);

        $tshirt = Tshirt::create($request->all());
        return redirect()->route('tshirts.index')->with('success', 'Product added successfully.');
    }

    // Update a t-shirt
    public function update(Request $request, Tshirt $tshirt)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
            'image' => 'required|string|max:5000',
        ]);

        $tshirt->update($request->all());
        return redirect()->route('tshirts.index')->with('success', 'Product updated successfully.');
    }
    
    public function create()
    {
        return view('tshirts.create');
    }
    public function edit(Tshirt $tshirt) {
        return view('tshirts.edit', compact('tshirt')); 
    }

    public function destroy(Tshirt $tshirt)
    {
        $tshirt->delete();
        return redirect()->route('tshirts.index')->with('success', 'Product deleted successfully.');
    }
}

