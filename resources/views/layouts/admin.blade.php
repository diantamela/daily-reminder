<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Daily Reminder') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app">
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a class="text-blue-600 text-xl font-bold hover:text-blue-700 transition-colors" href="{{ url('/admin/dashboard') }}">
                            <i class="fas fa-shield-alt mr-2"></i>Daily Reminder Admin
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <a class="text-gray-600 hover:text-blue-600 transition-colors px-3 py-2 rounded-md text-sm font-medium" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                        </a>
                        
                        <div class="relative group">
                            <button class="text-gray-600 hover:text-blue-600 transition-colors flex items-center space-x-1 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                                <i class="fas fa-user-shield mr-1"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-200" href="{{ route('admin.reminders.create') }}">
                                    <i class="fas fa-plus mr-2"></i>Create Reminder
                                </a>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-200" href="{{ route('home') }}">
                                    <i class="fas fa-home mr-2"></i>View User Site
                                </a>
                                <hr class="my-1 border-gray-200">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-200" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" class="text-gray-600 hover:text-blue-600 focus:outline-none focus:text-blue-600" id="mobile-menu-button">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile menu -->
                <div class="hidden md:hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <div class="text-gray-500 px-3 py-2 text-sm font-medium">{{ Auth::user()->name }}</div>
                        <a class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors" href="{{ route('admin.reminders.create') }}">
                            <i class="fas fa-plus mr-2"></i>Create Reminder
                        </a>
                        <a class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors" href="{{ route('home') }}">
                            <i class="fas fa-home mr-2"></i>View User Site
                        </a>
                        <a class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                        </a>
                    </div>
                </div>
            </div>
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