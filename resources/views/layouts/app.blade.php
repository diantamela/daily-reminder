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
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: none;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.15);
        }
        .reminder-card {
            min-height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }
        .reminder-message {
            font-size: 1.4rem;
            line-height: 1.6;
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .category-badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .streak-badge {
            background: linear-gradient(45deg, #10b981, #34d399) !important;
            color: white;
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }
        .days-badge {
            background: linear-gradient(45deg, #3b82f6, #60a5fa) !important;
            color: white;
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }
        .btn {
            border-radius: 2rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(45deg, #3b82f6, #60a5fa);
            border: none;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(59, 130, 246, 0.4);
        }
        .btn-success {
            background: linear-gradient(45deg, #10b981, #34d399);
            border: none;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(16, 185, 129, 0.4);
        }
        .form-control {
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .alert {
            border-radius: 1rem;
            border: none;
            backdrop-filter: blur(10px);
        }
        .alert-info {
            background: linear-gradient(45deg, #3b82f6, #60a5fa);
            color: white;
        }
        .text-success {
            color: #10b981 !important;
            font-weight: 600;
        }
        .container {
            max-width: 800px;
        }
        .header-stats {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1rem;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-sm navbar navbar-expand-md navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Daily Reminder') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    @if(!Auth::user()->hasRole('admin'))
                                        <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                                        <a class="dropdown-item" href="{{ route('reflections.index') }}">My Reflections</a>
                                    @endif
                                    
                                    @if(Auth::user()->hasRole('admin'))
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                                        <a class="dropdown-item" href="{{ route('admin.reminders.create') }}">Create Reminder</a>
                                    @endif
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>