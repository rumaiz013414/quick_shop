<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="py-12">
            <!-- Search Form -->
            <form id="search-form" action="{{ route('tshirts.search') }}" method="GET" class="mb-6">
                <input 
                    type="text" 
                    name="search" 
                    id="search-input" 
                    class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search T-shirts by name" 
                    autocomplete="off" 
                />
                <button 
                    type="submit" 
                    class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Search
                </button>
            </form>

            <!-- Search Suggestions Dropdown -->
            <div id="suggestions" class="bg-white border border-gray-300 rounded-md mt-1 max-h-40 overflow-y-auto hidden">
                <!-- Suggestions will appear here -->
            </div>
            
            <!-- Search Results Section -->
            <div id="search-results" class="mt-6">
                <!-- Results will be dynamically injected here -->
            </div>

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
                            <h4 class="font-bold text-xl">Average Price</h4>
                            <p class="text-2xl mt-2">${{ number_format($averagePrice ?? 0, 2) }}</p>
                        </div>

                        <!-- Most Stocked T-Shirt Card -->
                        <div class="bg-purple-100 p-4 rounded-lg shadow-md">
                            <h4 class="font-bold text-xl">Most Stocked T-Shirt</h4>
                            <p class="text-lg mt-2">{{ $mostStockedTshirt->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Least Stocked T-Shirt Card -->
                        <div class="bg-red-100 p-4 rounded-lg shadow-md">
                            <h4 class="font-bold text-xl">Least Stocked T-Shirt</h4>
                            <p class="text-lg mt-2">{{ $leastStockedTshirt->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="mt-8">
                        <h3 class="font-semibold text-lg mb-4">T-Shirt Stock Distribution</h3>
                        <canvas id="stockChart" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <!-- Include Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->

            <script>
                $(document).ready(function() {
                    // Handle search form submission with AJAX
                    $('#search-input').on('input', function() {
                        let searchQuery = $(this).val();
                        
                        if (searchQuery.length > 0) {
                            $.ajax({
                                url: "{{ route('tshirts.search') }}", // The search route
                                method: 'GET',
                                data: { search: searchQuery },
                                success: function(response) {
                                    // Empty the previous suggestions
                                    $('#suggestions').empty().removeClass('hidden');

                                    // If there are search suggestions, append them to the suggestions div
                                    if (response.length > 0) {
                                        response.forEach(function(tshirt) {
                                            $('#suggestions').append('<div class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-name="' + tshirt.name + '">' + tshirt.name + '</div>');
                                        });

                                        // Handle click on suggestion
                                        $('#suggestions div').on('click', function() {
                                            $('#search-input').val($(this).data('name'));
                                            $('#suggestions').empty().addClass('hidden');
                                        });
                                    } else {
                                        $('#suggestions').append('<p class="px-4 py-2">No suggestions found</p>');
                                    }
                                },
                                error: function() {
                                    $('#suggestions').empty().addClass('hidden');
                                }
                            });
                        } else {
                            $('#suggestions').empty().addClass('hidden');
                        }
                    });

                    // Handle search form submission
                    $('#search-form').on('submit', function(event) {
                        event.preventDefault(); // Prevent the form from submitting the traditional way

                        let searchQuery = $('#search-input').val();
                        
                        $.ajax({
                            url: "{{ route('tshirts.search') }}", // The search route
                            method: 'GET',
                            data: { search: searchQuery },
                            success: function(response) {
                                // Empty the previous results
                                $('#search-results').empty();

                                // If there are search results, append them to the search results div
                                if (response.length > 0) {
                                    let resultHtml = '<ul class="list-disc pl-5">';
                                    response.forEach(function(tshirt) {
                                        resultHtml += '<li>' + tshirt.name + '</li>';
                                    });
                                    resultHtml += '</ul>';

                                    $('#search-results').html(resultHtml);
                                } else {
                                    $('#search-results').html('<p>No results found</p>');
                                }
                            },
                            error: function() {
                                $('#search-results').html('<p>Something went wrong. Please try again.</p>');
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endsection
</x-app-layout>
