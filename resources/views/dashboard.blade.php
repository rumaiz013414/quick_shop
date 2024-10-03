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

                    <!-- Average Price Card -->
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                        <h4 class="font-bold text-xl">Sum Of Price</h4>
                        <p class="text-2xl mt-2">${{ number_format($totalPrice ?? 0, 2) }}</p>
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
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
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
    </script>

    @endsection
</x-app-layout>
