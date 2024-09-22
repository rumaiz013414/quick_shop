<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('orderItems.product')->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_price' => 'required|numeric',
            'items' => 'required|array',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return $order->load('orderItems.product');
    }

    public function show(Order $order)
    {
        return $order->load('orderItems.product');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order->update($request->all());
        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
