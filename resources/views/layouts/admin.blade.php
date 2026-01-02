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
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }
        .admin-navbar {
            backdrop-filter: blur(10px);
            background: rgba(30, 60, 114, 0.95) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .admin-navbar .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .admin-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .admin-navbar .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }
        .admin-navbar .dropdown-menu {
            background: rgba(30, 60, 114, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        .admin-navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        .admin-navbar .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateX(5px);
        }
        .admin-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.15);
        }
        .admin-card-header {
            background: linear-gradient(45deg, #1e3c72, #2a5298) !important;
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
            border: none;
            padding: 1.5rem;
        }
        .admin-btn-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(30, 60, 114, 0.3);
        }
        .admin-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(30, 60, 114, 0.4);
            background: linear-gradient(45deg, #2a5298, #1e3c72);
        }
        .admin-btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3);
        }
        .admin-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(40, 167, 69, 0.4);
        }
        .admin-btn-danger {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(220, 53, 69, 0.3);
        }
        .admin-btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(220, 53, 69, 0.4);
        }
        .admin-badge {
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .admin-table {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .admin-table thead th {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .admin-table tbody tr {
            transition: all 0.3s ease;
        }
        .admin-table tbody tr:hover {
            background: rgba(30, 60, 114, 0.05);
            transform: scale(1.01);
        }
        .admin-form-control {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .admin-form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
            transform: translateY(-1px);
        }
        .admin-alert {
            border-radius: 0.75rem;
            border: none;
            backdrop-filter: blur(10px);
            font-weight: 500;
        }
        .admin-alert-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        .admin-alert-info {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
        }
        .admin-stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            color: white;
            transition: all 0.3s ease;
        }
        .admin-stats-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="navbar navbar-expand-md admin-navbar navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/admin/dashboard') }}">
                    <i class="fas fa-shield-alt me-2"></i>Admin Panel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-shield me-1"></i>{{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.reminders.create') }}">
                                    <i class="fas fa-plus me-2"></i>Create Reminder
                                </a>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-home me-2"></i>View User Site
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>