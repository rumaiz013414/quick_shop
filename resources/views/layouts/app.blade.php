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
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 13V10m-5 5h6m6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Team Management (conditional rendering) -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <li>
                            <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a5 5 0 00-5-5h-4a5 5 0 00-5 5v2h5m0-16a3 3 0 110 6 3 3 0 010-6z" />
                                </svg>
                                Team Settings
                            </a>
                        </li>
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <li>
                                <a href="{{ route('teams.create') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                                    </svg>
                                    Create New Team
                                </a>
                            </li>
                        @endcan
                    @endif

                    <!-- Manage T-Shirts -->
                    <li>
                        <a href="{{ route('tshirts.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded {{ request()->routeIs('tshirts.*') ? 'bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                            </svg>
                            Manage Products
                        </a>
                    </li>

                    <!-- Manage Users -->
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded {{ request()->routeIs('users.*') ? 'bg-gray-700' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Manage Users
                        </a>
                    </li>
                        
                    <!-- Profile and Settings -->
                    <li>
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.012 8.012 0 0112 21c1.657 0 3.183-.537 4.438-1.438M8 9a4 4 0 118 0 4 4 0 01-8 0z" />
                            </svg>
                            Profile
                        </a>
                    </li>

                    <!-- API Tokens (conditional rendering) -->
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <li>
                            <a href="{{ route('api-tokens.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-6 6a9 9 0 100-18 9 9 0 000 18z" />
                                </svg>
                                API Tokens
                            </a>
                        </li>
                    @endif

                    <!-- Log Out -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="block w-full">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H4a3 3 0 01-3-3V5a3 3 0 013-3h6a3 3 0 013 3v1" />
                                </svg>
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
