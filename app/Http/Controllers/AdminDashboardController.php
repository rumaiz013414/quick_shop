<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use App\Models\Sale;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch t-shirt analytics data
        $totalTshirts = Tshirt::count();
        $totalStock = Tshirt::sum('stock');
        $totalPrice = Tshirt::sum('price');
        $mostStockedTshirt = Tshirt::orderBy('stock', 'desc')->first();
        $leastStockedTshirt = Tshirt::orderBy('stock', 'asc')->first();

        // Fetch sales data
        $totalSales = Sale::sum('total_price');
        $totalUnitsSold = Sale::sum('quantity');
        $tshirtSalesNames = Tshirt::has('sales')->pluck('name'); // Get names of T-shirts with sales
        $salesQuantities = Tshirt::withSum('sales', 'quantity')->pluck('sales_sum_quantity'); // Get sales quantities

        // Fetch stock distribution for the chart
        $tshirts = Tshirt::all();
        $tshirtNames = $tshirts->pluck('name');
        $stockQuantities = $tshirts->pluck('stock');

        // Pass this data to the dashboard view
        return view('dashboard', compact(
            'totalTshirts', 
            'totalStock', 
            'totalPrice', 
            'mostStockedTshirt', 
            'leastStockedTshirt',
            'totalSales',
            'totalUnitsSold',
            'tshirtSalesNames',
            'salesQuantities',
            'tshirtNames',
            'stockQuantities'
        ));
    }
}
