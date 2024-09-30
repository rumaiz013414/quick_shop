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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white h-screen fixed">
            <div class="p-4">
                <h2 class="text-lg font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-4">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    <!-- Team Management (conditional rendering) -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <li>
                            <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                                Team Settings
                            </a>
                        </li>
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <li>
                                <a href="{{ route('teams.create') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                                    Create New Team
                                </a>
                            </li>
                        @endcan
                    @endif

                    <!-- Manage T-Shirts -->
                    <li>
                        <a href="{{ route('tshirts.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded {{ request()->routeIs('tshirts.*') ? 'bg-gray-700' : '' }}">
                            Manage Products
                        </a>
                    </li>

                    <!-- Profile and Settings -->
                    <li>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                            Profile
                        </a>
                    </li>

                    <!-- API Tokens (conditional rendering) -->
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <li>
                            <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                                API Tokens
                            </a>
                        </li>
                    @endif

                    <!-- Log Out -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="block w-full">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            <!-- Header -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
        
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <div class="max-w-full mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
        
    </div>

    <!-- Include any additional scripts here -->
    @yield('scripts')
</body>
</html>
