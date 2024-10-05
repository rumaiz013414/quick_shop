<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;


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

        // Sales by month (last 12 months)
        $monthlySales = Sale::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Sales by year (last 5 years)
        $yearlySales = Sale::selectRaw('YEAR(created_at) as year, SUM(total_price) as total')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Prepare data for the line charts
        $monthlyLabels = [];
        $monthlyValues = [];
        foreach ($monthlySales as $sale) {
            $monthName = Carbon::create($sale->year, $sale->month)->format('F Y');
            $monthlyLabels[] = $monthName;
            $monthlyValues[] = $sale->total;
        }

        $yearlyLabels = $yearlySales->pluck('year');
        $yearlyValues = $yearlySales->pluck('total');


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
            'stockQuantities',
            'monthlyLabels', 
            'monthlyValues', 
            'yearlyLabels', 
            'yearlyValues'
        ));
    }
}
