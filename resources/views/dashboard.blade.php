<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <!-- Analytics Overview -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Analytics Overview</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Total T-Shirts Card -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Total Design Types</h4>
                        <p class="text-2xl mt-2">{{ $totalTshirts ?? 'No Data' }}</p>
                    </div>

                    <!-- Total Stock Card -->
                    <div class="bg-green-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Total Stock</h4>
                        <p class="text-2xl mt-2">{{ $totalStock ?? 'No Data' }}</p>
                    </div>

                    <!-- Most Stocked T-Shirt Card -->
                    <div class="bg-purple-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Most Stocked Product</h4>
                        <p class="text-lg mt-2">{{ $mostStockedTshirt->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Least Stocked T-Shirt Card -->
                    <div class="bg-red-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Least Stocked Product</h4>
                        <p class="text-lg mt-2">{{ $leastStockedTshirt->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Total Sales Card -->
                    <div class="bg-indigo-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Total Sales (Revenue)</h4>
                        <p class="text-2xl mt-2">${{ number_format($totalSales ?? 0, 2) }}</p>
                    </div>

                    <!-- Total Units Sold Card -->
                    <div class="bg-teal-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Total Units Sold</h4>
                        <p class="text-2xl mt-2">{{ $totalUnitsSold ?? 'No Data' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Distribution Chart -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Inventory</h3>
                <canvas id="stockChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Sales Distribution Chart -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Sales</h3>
                <canvas id="salesChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Monthly Sales (Last 12 Months)</h3>
                <canvas id="monthlySalesChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Yearly Sales Chart -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Yearly Sales (Last 5 Years)</h3>
                <canvas id="yearlySalesChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Stock Distribution Chart
        var ctxStock = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: @json($tshirtNames), // T-Shirt names
                datasets: [{
                    label: 'Stock Quantity',
                    data: @json($stockQuantities), // Stock quantities
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales Distribution Chart
        var ctxSales = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: @json($tshirtSalesNames), // T-Shirt names for sales
                datasets: [{
                    label: 'Units Sold',
                    data: @json($salesQuantities), // Sales quantities per T-shirt
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Sales Line Chart
        var ctxMonthly = document.getElementById('monthlySalesChart').getContext('2d');
        var monthlySalesChart = new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels), // Month names
                datasets: [{
                    label: 'Total Sales ($)',
                    data: @json($monthlyValues), // Monthly sales values
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Yearly Sales Line Chart
        var ctxYearly = document.getElementById('yearlySalesChart').getContext('2d');
        var yearlySalesChart = new Chart(ctxYearly, {
            type: 'line',
            data: {
                labels: @json($yearlyLabels), // Years
                datasets: [{
                    label: 'Total Sales ($)',
                    data: @json($yearlyValues), // Yearly sales values
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    @endsection
</x-app-layout>
