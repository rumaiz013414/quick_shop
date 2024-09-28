<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Web: Get all products
    public function index()
    {
        $products = $this->getAllProducts();
        return view('products.index', compact('products'));
    }

    // API: Get all products
    public function apiIndex()
    {
        $products = $this->getAllProducts();
        return response()->json($products);
    }

    // Web: Show create product form
    public function create()
    {
        return view('products.create');
    }

    // API: Store a new product
    public function store(Request $request)
    {
        $this->validateProduct($request); // Moved validation to a separate method

        $product = Product::create($request->all());

        // Check if it's an API request or web request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'Product created successfully.',
                'product' => $product
            ], 201);
        }

        // Redirect for web
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Web: Show a single product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // API: Get a single product
    public function apiShow(Product $product)
    {
        return response()->json($product);
    }

    // Web: Show edit product form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // API: Update a product
    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request, true); // Pass true for update validation

        $product->update($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'Product updated successfully.',
                'product' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Web: Delete a product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    // API: Delete a product
    public function apiDestroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }

    // Helper method to get all products
    protected function getAllProducts()
    {
        return Product::all();
    }

    // Validation method to validate product data
    protected function validateProduct(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'description' => $isUpdate ? 'sometimes|required|string' : 'required|string',
            'price' => $isUpdate ? 'sometimes|required|numeric' : 'required|numeric',
        ];

        $request->validate($rules);
    }
}
