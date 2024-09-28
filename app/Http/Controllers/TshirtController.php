<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtController extends Controller
{
    // Show all T-shirts for the web view
    public function webindex()
    {
        $tshirts = Tshirt::all();
        return view('tshirts.index', compact('tshirts'));
    }

    // Show the form for creating a new T-shirt
    public function create()
    {
        return view('tshirts.create'); // Return the view for creating a new T-shirt
    }

    // Store a new T-shirt
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
        return redirect()->route('tshirts.index')->with('success', 'T-shirt created successfully.');
    }

    // Show a single T-shirt by ID for web view
    public function show(Tshirt $tshirt)
    {
        return view('tshirts.show', compact('tshirt')); // Return the show view for a single T-shirt
    }

    // Show the form for editing a T-shirt
    public function edit(Tshirt $tshirt)
    {
        return view('tshirts.edit', compact('tshirt')); // Return the edit view
    }

    // Update a T-shirt
    public function update(Request $request, Tshirt $tshirt)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'color' => 'sometimes|required|string|max:255',
        'size' => 'sometimes|required|string|max:255',
        'price' => 'sometimes|required|numeric|min:0',
        'stock' => 'sometimes|required|integer|min:0',
    ]);

    // Update the T-shirt with the validated data
    $tshirt->update($request->all());

    // Redirect back to the index route with a success message
    return redirect()->route('tshirts.index')->with('success', 'T-shirt updated successfully.');
}

    // Delete a T-shirt
    public function destroy(Tshirt $tshirt)
    {
        $tshirt->delete();
        return redirect()->route('tshirts.index')->with('success', 'T-shirt deleted successfully.');
    }
}
