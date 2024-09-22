<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white h-screen">
            <div class="p-4">
                <h2 class="text-lg font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-4">
                <ul>
                    <li>
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 hover:bg-gray-700">Manage Products</a>
                    </li>
                    <!-- Add other navigation links here -->
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Navigation Menu -->
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="bg-white shadow mb-6">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="max-w-7xl mx-auto">
                @yield('content') <!-- Change this line to yield content -->
            </div>
        </main>
    </div>

    <!-- Include any additional scripts here -->
    @yield('scripts') <!-- Use this for page-specific scripts -->
</body>
</html>
