<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
{
    // Fetch t-shirt analytics data
    $totalTshirts = Tshirt::count();
    $totalStock = Tshirt::sum('stock');
    $averagePrice = Tshirt::average('price');
    $mostStockedTshirt = Tshirt::orderBy('stock', 'desc')->first();
    $leastStockedTshirt = Tshirt::orderBy('stock', 'asc')->first();

    // Fetch stock distribution for the chart
    $tshirts = Tshirt::all();
    $tshirtNames = $tshirts->pluck('name');
    $stockQuantities = $tshirts->pluck('stock');

    // Pass this data to the dashboard view
    return view('dashboard', compact(
        'totalTshirts', 
        'totalStock', 
        'averagePrice', 
        'mostStockedTshirt', 
        'leastStockedTshirt',
        'tshirtNames',
        'stockQuantities'
    ));
}
}
