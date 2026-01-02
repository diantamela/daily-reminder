<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Daily Reminder') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

</head>
<body class="bg-gradient-to-br from-purple-500 to-purple-700 min-h-screen">
    <div id="app">
        <nav class="navbar shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Daily Reminder') }}
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            @endif
                            
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            @endif
                        @else
                            <div class="relative group">
                                <button class="nav-link flex items-center space-x-1">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    @if(!Auth::user()->hasRole('admin'))
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('home') }}">Home</a>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('reflections.index') }}">My Reflections</a>
                                    @endif
                                    
                                    @if(Auth::user()->hasRole('admin'))
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.reminders.create') }}">Create Reminder</a>
                                    @endif
                                    
                                    <hr class="my-1">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700" id="mobile-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile menu -->
                <div class="hidden md:hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        @guest
                            @if (Route::has('login'))
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('login') }}">Login</a>
                            @endif
                            
                            @if (Route::has('register'))
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('register') }}">Register</a>
                            @endif
                        @else
                            <div class="text-gray-700 px-3 py-2 text-sm font-medium">{{ Auth::user()->name }}</div>
                            @if(!Auth::user()->hasRole('admin'))
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('home') }}">Home</a>
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('reflections.index') }}">My Reflections</a>
                            @endif
                            
                            @if(Auth::user()->hasRole('admin'))
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                                <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('admin.reminders.create') }}">Create Reminder</a>
                            @endif
                            
                            <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        @endguest
        </nav>
        
        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        </script>

        <main class="py-8">
            @yield('content')
        </main>
    </div>
    

</body>
</html>