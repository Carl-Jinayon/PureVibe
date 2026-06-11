<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PureVibe</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --accent-color: #7c3aed;
            --sidebar-bg: #1e1b4b;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --bg-color: #f3f4f6;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            color: #1f2937;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            overflow: hidden;
        }

        .sidebar .nav-link span,
        .sidebar-brand span,
        .sidebar .btn span {
            transition: opacity 0.2s ease, width 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-brand span,
        .sidebar.collapsed .btn span {
            opacity: 0;
            width: 0;
            display: inline-block !important;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-brand span {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: var(--accent-color);
        }

        .nav-link i {
            font-size: 1.2rem;
        }

        /* Sub-menus */
        .sub-menu {
            list-style: none;
            padding-left: 0;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sub-menu .nav-link {
            padding-left: 50px;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #4b5563;
            cursor: pointer;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            border-bottom: none;
        }

        /* Buttons */
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--accent-color));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        /* Tables */
        .table-custom {
            background: transparent;
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: rgba(243, 244, 246, 0.8);
            border-bottom: 2px solid #e5e7eb;
            color: #4b5563;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .table-custom tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-custom tbody tr:hover {
            background-color: rgba(249, 250, 251, 0.8);
        }

        .table-custom td {
            vertical-align: middle;
        }

        /* Form Controls */
        .form-control-custom {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Badges */
        .badge-custom {
            padding: 0.4em 0.8em;
            border-radius: 9999px;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @php
        // Safe check if Product class exists and user is authenticated
        $lowStockCount = 0;
        if(class_exists('\App\Models\Product')) {
            try {
                $lowStockCount = \App\Models\Product::where('current_stock', '<=', \Illuminate\Support\Facades\DB::raw('low_stock_threshold'))->where('is_active', true)->count();
            } catch(\Exception $e) {}
        }
    @endphp

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-basket2-fill text-white"></i>
                <span class="d-inline">PureVibe</span>
            </a>
        </div>
        
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span class="d-inline">Dashboard</span>
                </a>
            </li>
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isInventoryManager()))
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> <span class="d-inline">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> <span class="d-inline">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> <span class="d-inline">Suppliers</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.inventory.*') ? 'show' : '' }}">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#inventoryMenu">
                    <i class="bi bi-clipboard-data"></i> <span class="d-inline">Inventory</span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="sub-menu collapse {{ request()->routeIs('admin.inventory.*') ? 'show' : '' }}" id="inventoryMenu">
                    <li><a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.index') ? 'text-white' : '' }}">Stock Levels</a></li>
                    <li><a href="{{ route('admin.inventory.adjust-form') }}" class="nav-link {{ request()->routeIs('admin.inventory.adjust-form') ? 'text-white' : '' }}">Quick Control</a></li>
                    <li><a href="{{ route('admin.inventory.movements') }}" class="nav-link {{ request()->routeIs('admin.inventory.movements') ? 'text-white' : '' }}">Movements</a></li>
                    <li><a href="{{ route('admin.inventory.low-stock') }}" class="nav-link {{ request()->routeIs('admin.inventory.low-stock') ? 'text-white' : '' }}">Low Stock</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.stock-entries.index') }}" class="nav-link {{ request()->routeIs('admin.stock-entries.*') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> <span class="d-inline">Stock Entries</span>
                </a>
            </li>
            @endif

            <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                    <i class="bi bi-graph-up"></i> <span class="d-inline">Reports</span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="sub-menu collapse {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}" id="reportsMenu">
                    <li><a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.index') ? 'text-white' : '' }}">Overview</a></li>
                    <li><a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'text-white' : '' }}">Sales</a></li>
                    <li><a href="{{ route('admin.reports.top-products') }}" class="nav-link {{ request()->routeIs('admin.reports.top-products') ? 'text-white' : '' }}">Top Products</a></li>
                    <li><a href="{{ route('admin.reports.inventory') }}" class="nav-link {{ request()->routeIs('admin.reports.inventory') ? 'text-white' : '' }}">Inventory</a></li>
                    <li><a href="{{ route('admin.reports.low-stock') }}" class="nav-link {{ request()->routeIs('admin.reports.low-stock') ? 'text-white' : '' }}">Low Stock</a></li>
                    <li><a href="{{ route('admin.reports.suppliers') }}" class="nav-link {{ request()->routeIs('admin.reports.suppliers') ? 'text-white' : '' }}">Suppliers</a></li>
                    <li><a href="{{ route('admin.reports.transactions') }}" class="nav-link {{ request()->routeIs('admin.reports.transactions') ? 'text-white' : '' }}">Transactions</a></li>
                </ul>
            </li>

            <li class="nav-item mt-3 mb-2">
                <span class="nav-link text-uppercase fw-bold" style="font-size: 0.75rem; color: #a5b4fc; letter-spacing: 0.05em;">DCIT 55A Project</span>
            </li>
            
            @if(auth()->check() && auth()->user()->isAdmin())
            <li class="nav-item">
                <a href="{{ route('admin.sql-runner.index') }}" class="nav-link {{ request()->routeIs('admin.sql-runner.*') ? 'active' : '' }}" style="border-left-color: #22c55e;">
                    <i class="bi bi-terminal" style="color: #4ade80;"></i> <span class="d-inline" style="color: #4ade80;">SQL Runner</span>
                </a>
            </li>
            @endif

            @if(auth()->check() && (method_exists(auth()->user(), 'isAdmin') ? auth()->user()->isAdmin() : auth()->user()->role === 'admin'))
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span class="d-inline">Users</span>
                </a>
            </li>
            @endif

            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isAuditor()))
            <li class="nav-item">
                <a href="{{ route('admin.audit-logs.index') }}" class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> <span class="d-inline">Audit Logs</span>
                </a>
            </li>
            @endif

            @if(auth()->check() && (method_exists(auth()->user(), 'isAdmin') ? auth()->user()->isAdmin() : auth()->user()->role === 'admin'))
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> <span class="d-inline">Settings</span>
                </a>
            </li>
            @endif
        </ul>

        <div class="mt-auto p-3 border-top border-secondary">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> <span class="d-inline">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="toggle-btn" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="position-relative d-none d-md-block" id="globalSearchContainer">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="z-index:5; pointer-events:none;"></i>
                    <input type="text" id="globalSearchInput" class="form-control form-control-custom rounded-pill" placeholder="Search..." style="width: 250px; padding-left: 2.2rem;" autocomplete="off">
                    <ul class="dropdown-menu w-100 shadow-sm" id="globalSearchDropdown" style="position: absolute; top: 100%; left: 0; margin-top: 0.5rem; border-radius: 12px; border: 1px solid var(--glass-border); max-height: 300px; overflow-y: auto;">
                        <!-- Suggestions will be injected here -->
                    </ul>
                </div>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="position-relative">
                    <a href="{{ route('admin.inventory.low-stock') }}" class="text-dark" id="notifBell">
                        <i class="bi bi-bell fs-5"></i>
                        @php $notifDismissed = session('notif_dismissed_at'); $notifCurrent = $lowStockCount > 0; @endphp
                        @if($notifCurrent && !$notifDismissed)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge" style="font-size: 0.6rem;">
                                {{ $lowStockCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-gradient text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                            {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : 'A' }}
                        </div>
                        <div class="ms-2 d-none d-md-block">
                            <span class="d-block fw-semibold" style="line-height: 1;">{{ auth()->check() ? auth()->user()->name : 'Admin User' }}</span>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ auth()->check() && auth()->user()->role ? ucfirst(auth()->user()->role->name) : 'Administrator' }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ route('admin.users.edit', auth()->id()) }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                        @if(auth()->user() && auth()->user()->hasRole(\App\Models\Role::ADMIN))
                            <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid p-4 flex-grow-1 animate-fade-in">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 glass-card mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 glass-card mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 glass-card mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 glass-card mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-auto py-3 bg-white border-top text-center text-muted">
            <small>&copy; {{ date('Y') }} PureVibe. All rights reserved.</small>
        </footer>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation Search with Dropdown
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('globalSearchDropdown');
            const searchContainer = document.getElementById('globalSearchContainer');

            if (searchInput) {
                const routes = [
                    { name: 'Dashboard', url: '{{ route("admin.dashboard") }}', icon: 'bi-speedometer2' },
                    @if(auth()->check() && !auth()->user()->isAuditor())
                    { name: 'Products', url: '{{ route("admin.products.index") }}', icon: 'bi-box-seam' },
                    { name: 'Categories', url: '{{ route("admin.categories.index") }}', icon: 'bi-tags' },
                    { name: 'Suppliers', url: '{{ route("admin.suppliers.index") }}', icon: 'bi-truck' },
                    { name: 'Inventory', url: '{{ route("admin.inventory.index") }}', icon: 'bi-clipboard-data' },
                    { name: 'Stock Entries', url: '{{ route("admin.stock-entries.index") }}', icon: 'bi-plus-circle' },
                    @endif
                    { name: 'Reports', url: '{{ route("admin.reports.index") }}', icon: 'bi-graph-up' },
                    { name: 'Transactions', url: '{{ route("admin.reports.transactions") }}', icon: 'bi-receipt' },
                    @if(auth()->check() && auth()->user()->isAdmin())
                    { name: 'Users', url: '{{ route("admin.users.index") }}', icon: 'bi-people' },
                    { name: 'Settings', url: '{{ route("admin.settings.index") }}', icon: 'bi-gear' },
                    { name: 'SQL Runner', url: '{{ route("admin.sql-runner.index") }}', icon: 'bi-terminal' },
                    @endif
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isAuditor()))
                    { name: 'Audit Logs', url: '{{ route("admin.audit-logs.index") }}', icon: 'bi-journal-text' },
                    @endif
                    { name: 'Kiosk', url: '{{ route("kiosk.index") }}', icon: 'bi-basket2-fill' }
                ];

                function renderSuggestions(searchTerm) {
                    searchDropdown.innerHTML = '';
                    const term = searchTerm.toLowerCase().trim();
                    if (term.length === 0) {
                        searchDropdown.classList.remove('show');
                        return;
                    }

                    const filtered = routes.filter(r => r.name.toLowerCase().includes(term));

                    if (filtered.length > 0) {
                        filtered.forEach(route => {
                            const li = document.createElement('li');
                            li.innerHTML = `<a class="dropdown-item d-flex align-items-center py-2" href="${route.url}">
                                <i class="bi ${route.icon} me-2 text-muted"></i> 
                                <span>${route.name.replace(new RegExp(term, 'gi'), match => `<strong>${match}</strong>`)}</span>
                            </a>`;
                            searchDropdown.appendChild(li);
                        });
                        searchDropdown.classList.add('show');
                    } else {
                        searchDropdown.innerHTML = '<li class="px-3 py-2 text-muted small">No matching sections found.</li>';
                        searchDropdown.classList.add('show');
                    }
                }

                searchInput.addEventListener('input', function() {
                    renderSuggestions(this.value);
                });

                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length > 0) {
                        renderSuggestions(this.value);
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchContainer.contains(e.target)) {
                        searchDropdown.classList.remove('show');
                    }
                });

                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const term = this.value.toLowerCase().trim();
                        const match = routes.find(r => r.name.toLowerCase().includes(term));
                        if (match) {
                            window.location.href = match.url;
                        }
                    }
                });
            }

            // Sidebar Toggle Logic
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const navTexts = document.querySelectorAll('.sidebar span');
            const subMenus = document.querySelectorAll('.sub-menu');

            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                const isCollapsed = sidebar.classList.contains('collapsed');
                navTexts.forEach(span => {
                    span.style.display = isCollapsed ? 'none' : 'inline';
                });
                if (isCollapsed) {
                    // Collapse all open Bootstrap collapse submenus
                    document.querySelectorAll('.sub-menu.collapse.show').forEach(collapse => {
                        let bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapse);
                        bsCollapse.hide();
                    });
                    // Also hide the parent nav-item show class
                    document.querySelectorAll('.nav-item.show').forEach(item => item.classList.remove('show'));
                }
            }

            sidebarToggle.addEventListener('click', () => {
                if(window.innerWidth > 768) {
                    toggleSidebar();
                } else {
                    sidebar.classList.toggle('show');
                }
            });

            const dropdownLinks = document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (sidebar.classList.contains('collapsed') && window.innerWidth > 768) {
                        toggleSidebar();
                    }
                });
            });

            // Notification bell: store dismissal in sessionStorage
            const notifBell = document.getElementById('notifBell');
            const notifBadge = document.getElementById('notifBadge');
            if(notifBell && notifBadge) {
                if(sessionStorage.getItem('notif_dismissed')) {
                    notifBadge.style.display = 'none';
                }
                notifBell.addEventListener('click', function() {
                    sessionStorage.setItem('notif_dismissed', '1');
                    if(notifBadge) notifBadge.style.display = 'none';
                });
            }
        });

        // Simple confirmation for all delete forms
        function confirmDelete(message = 'Are you sure you want to delete this item?') {
            return confirm(message);
        }
    </script>
    @yield('scripts')
</body>
</html>
