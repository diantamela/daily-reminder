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
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #ffffff 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(59, 130, 246, 0.3);
        }
        
        .admin-sidebar.collapsed {
            width: 70px;
        }
        
        .admin-main {
            margin-left: 280px;
            flex: 1;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .admin-main.expanded {
            margin-left: 70px;
        }
        
        .admin-header {
            background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 50%, #ffffff 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(236, 72, 153, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.1);
        }
        
        .admin-content {
            padding: 2rem;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            background: linear-gradient(180deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
        }
        
        .sidebar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .sidebar-brand:hover {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }
        
        .sidebar-brand i {
            margin-right: 0.75rem;
            font-size: 1.75rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-section-title {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }
        
        .nav-link:hover {
            background: rgba(59, 130, 246, 0.15);
            color: white;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-left: 4px solid #3b82f6;
            transform: translateX(0);
        }
        
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #3b82f6;
        }
        
        .nav-link.active .nav-icon {
            color: #3b82f6;
            text-shadow: 0 0 8px rgba(59, 130, 246, 0.6);
            transform: scale(1.1);
        }
        
        .nav-icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .sidebar-user {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: auto;
            background: linear-gradient(180deg, rgba(37, 99, 235, 0.1) 0%, rgba(29, 78, 216, 0.2) 100%);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            color: white;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }
        
        .user-details h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .user-details small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }
        
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .admin-content {
                padding: 1rem;
            }
        }
        
        /* Collapsed sidebar styles */
        .admin-sidebar.collapsed .sidebar-brand span,
        .admin-sidebar.collapsed .nav-section-title,
        .admin-sidebar.collapsed .nav-link span,
        .admin-sidebar.collapsed .user-details,
        .admin-sidebar.collapsed .sidebar-user .user-info span {
            display: none;
        }
        
        .admin-sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
            position: relative;
        }
        
        .admin-sidebar.collapsed .nav-link:hover {
            transform: translateX(0) scale(1.05);
        }
        
        .admin-sidebar.collapsed .sidebar-user {
            padding: 1rem;
        }
        
        .admin-sidebar.collapsed .user-avatar {
            margin: 0 auto;
        }
        
        /* Tooltip for collapsed state */
        .admin-sidebar.collapsed .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1002;
            margin-left: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .admin-sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
            visibility: visible;
        }
        
        .admin-sidebar.collapsed .nav-section-title::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 0;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1002;
            margin-left: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .admin-sidebar.collapsed .nav-section-title:hover::after {
            opacity: 1;
            visibility: visible;
        }
        
        /* Main content cards */
        .admin-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
            backdrop-filter: blur(10px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(239, 246, 255, 0.9) 100%);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(59, 130, 246, 0.15);
        }
        
        .admin-card-header {
            background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%) !important;
            color: #1e40af;
            border-radius: 1rem 1rem 0 0 !important;
            border: none;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(236, 72, 153, 0.1);
        }
        
        .btn-admin {
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
            color: white;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(59, 130, 246, 0.4);
            background: linear-gradient(45deg, #2563eb, #3b82f6);
            color: white;
        }
        
        .stats-card {
            background: linear-gradient(135deg, rgba(252, 231, 243, 0.8), rgba(243, 232, 255, 0.6));
            border: 1px solid rgba(236, 72, 153, 0.2);
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            color: #be185d;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, rgba(239, 246, 255, 0.9), rgba(219, 234, 254, 0.7));
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        
        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times d-none"></i>
        </button>
        
        <!-- Overlay for mobile -->
        <div class="overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-shield-alt"></i>
                    <span>Admin Panel</span>
                    <i class="fas fa-crown ms-2 text-warning"></i>
                </a>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title" data-tooltip="Main Menu">
                        <i class="fas fa-layer-group me-2"></i>Main
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.reminders.create') }}" class="nav-link {{ request()->routeIs('admin.reminders.create') ? 'active' : '' }}" data-tooltip="Create Reminder">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <span>Create Reminder</span>
                        </a>
                    </div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title" data-tooltip="Management">
                        <i class="fas fa-cogs me-2"></i>Management
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}#reminders" class="nav-link" data-tooltip="All Reminders">
                            <i class="nav-icon fas fa-list"></i>
                            <span>All Reminders</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}?filter=active" class="nav-link" data-tooltip="Active Reminders">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <span>Active Reminders</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}?filter=inactive" class="nav-link" data-tooltip="Inactive Reminders">
                            <i class="nav-icon fas fa-pause-circle"></i>
                            <span>Inactive Reminders</span>
                        </a>
                    </div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title" data-tooltip="Quick Actions">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link" target="_blank" data-tooltip="View User Site">
                            <i class="nav-icon fas fa-external-link-alt"></i>
                            <span>View User Site</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('reflections.index') }}" class="nav-link" target="_blank" data-tooltip="View Reflections">
                            <i class="nav-icon fas fa-comments"></i>
                            <span>View Reflections</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <h6>
                            <i class="fas fa-user-shield me-2"></i>{{ Auth::user()->name }}
                        </h6>
                        <small>
                            <i class="fas fa-badge-check me-1"></i>Administrator
                        </small>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="nav-link" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;" data-tooltip="Logout">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 text-white">
                            @if(request()->routeIs('admin.dashboard'))
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                <i class="fas fa-chart-line ms-2 opacity-75"></i>
                            @elseif(request()->routeIs('admin.reminders.create'))
                                <i class="fas fa-plus-circle me-2"></i>Create Reminder
                                <i class="fas fa-sparkles ms-2 opacity-75"></i>
                            @elseif(request()->routeIs('admin.reminders.edit'))
                                <i class="fas fa-edit me-2"></i>Edit Reminder
                                <i class="fas fa-pencil-alt ms-2 opacity-75"></i>
                            @endif
                        </h4>
                        <small class="text-white-50">Manage your daily reminders and track system activity</small>
                    </div>
                    <div>
                        <button class="btn btn-admin" id="collapseToggle">
                            <i class="fas fa-compress-alt me-2" id="collapseIcon"></i>
                            <span id="collapseText">Collapse</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.querySelector('.admin-main');
            const toggleBtn = document.getElementById('sidebarToggle');
            const collapseBtn = document.getElementById('collapseToggle');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Mobile toggle
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                
                // Toggle icons
                const barsIcon = toggleBtn.querySelector('.fa-bars');
                const timesIcon = toggleBtn.querySelector('.fa-times');
                
                if (sidebar.classList.contains('show')) {
                    barsIcon.classList.add('d-none');
                    timesIcon.classList.remove('d-none');
                } else {
                    barsIcon.classList.remove('d-none');
                    timesIcon.classList.add('d-none');
                }
            });
            
            // Close sidebar on overlay click (mobile)
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                
                // Reset icons
                const barsIcon = toggleBtn.querySelector('.fa-bars');
                const timesIcon = toggleBtn.querySelector('.fa-times');
                barsIcon.classList.remove('d-none');
                timesIcon.classList.add('d-none');
            });
            
            // Desktop collapse
            collapseBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');
                
                const icon = document.getElementById('collapseIcon');
                const text = document.getElementById('collapseText');
                
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-expand-alt me-2';
                    text.textContent = 'Expand';
                } else {
                    icon.className = 'fas fa-compress-alt me-2';
                    text.textContent = 'Collapse';
                }
            });
            
            // Auto-collapse on desktop if screen is small
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                main.classList.remove('expanded');
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    main.classList.remove('expanded');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>