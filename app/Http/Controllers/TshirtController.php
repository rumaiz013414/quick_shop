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
        return view('tshirts.index', compact('tshirts'));  // Return the view instead of JSON
    }

    // Get a single t-shirt by ID
    public function show(Tshirt $tshirt)
    {
        return response()->json($tshirt);
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
        ]);

        $tshirt = Tshirt::create($request->all());
        return redirect()->route('tshirts.index')->with('success', 'T-shirt added successfully.');
    }

    // Update a t-shirt
    public function update(Request $request, Tshirt $tshirt)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:255',
            'size' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $tshirt->update($request->all());
        return redirect()->route('tshirts.index')->with('success', 'T-shirt updated successfully.');
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
        return redirect()->route('tshirts.index')->with('success', 'T-shirt deleted successfully.');
    }
}

