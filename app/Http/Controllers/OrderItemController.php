<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Fetch all order items for a specific order
    public function index($orderId)
    {
        return OrderItem::where('order_id', $orderId)->with('product')->get();
    }

    // Store a new order item
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        return OrderItem::create($request->all());
    }

    // Show a specific order item
    public function show(OrderItem $orderItem)
    {
        return $orderItem->load('product');
    }

    // Update an existing order item
    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric',
        ]);

        $orderItem->update($request->all());
        return $orderItem->load('product');
    }

    // Delete an order item
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->noContent();
    }
}
