<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel WIS — @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- ── SIDEBAR ─────────────────────────────────────────────── --}}
<aside class="sidebar">

    <a class="sidebar-brand" href="{{ route('dashboard') }}">
        <div class="brand-icon"><i class="bi bi-building"></i></div>
        <div>
            <span class="brand-name">Hotel WIS</span>
            <span class="brand-sub">Internal Operations</span>
        </div>
    </a>

    <nav class="sidebar-nav">

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Core Records</div>

        <a href="{{ route('guests.index') }}"
           class="nav-link {{ request()->routeIs('guests.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Guests
        </a>

        <a href="{{ route('rooms.index') }}"
           class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i class="bi bi-door-open"></i> Rooms
        </a>

        <a href="{{ route('employees.index') }}"
           class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Employees
        </a>

        <a href="{{ route('services.index') }}"
           class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Services
        </a>

        <a href="{{ route('facilities.index') }}"
           class="nav-link {{ request()->routeIs('facilities.*') ? 'active' : '' }}">
            <i class="bi bi-building-check"></i> Facilities
        </a>

        <div class="sidebar-section">Transactions</div>

        <a href="{{ route('reservations.index') }}"
           class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Reservations
        </a>

        <a href="{{ route('checkinout.index') }}"
           class="nav-link {{ request()->routeIs('checkinout.*') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right"></i> Check-in / Out
        </a>

        <a href="{{ route('servicerequests.index') }}"
           class="nav-link {{ request()->routeIs('servicerequests.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-check"></i> Service Requests
        </a>

        <a href="{{ route('schedules.index') }}"
           class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Scheduling
        </a>

        <a href="{{ route('facilitybookings.index') }}"
           class="nav-link {{ request()->routeIs('facilitybookings.*') ? 'active' : '' }}">
            <i class="bi bi-bookmark-check"></i> Facility Bookings
        </a>

        <div class="sidebar-section">Reports</div>

        <a href="{{ route('reports.occupancy') }}"
           class="nav-link {{ request()->routeIs('reports.occupancy') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> Occupancy
        </a>

        <a href="{{ route('reports.revenue') }}"
           class="nav-link {{ request()->routeIs('reports.revenue') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Revenue
        </a>

        <a href="{{ route('reports.service-usage') }}"
           class="nav-link {{ request()->routeIs('reports.service-usage') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i> Service Usage
        </a>

        <a href="{{ route('reports.employee-workload') }}"
           class="nav-link {{ request()->routeIs('reports.employee-workload') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Employee Workload
        </a>

        <a href="{{ route('reports.facility-utilization') }}"
           class="nav-link {{ request()->routeIs('reports.facility-utilization') ? 'active' : '' }}">
            <i class="bi bi-pie-chart"></i> Facility Utilization
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="u-name">{{ auth()->user()->name }}</div>
                <div class="u-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

</aside>

{{-- ── MAIN WRAPPER ─────────────────────────────────────────── --}}
<div class="main-wrapper">

    {{-- Topbar --}}
    <header class="topbar">
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
        <span class="topbar-meta">
            <i class="bi bi-calendar3"></i>
            {{ now()->format('F d, Y') }}
        </span>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error'))
    <div class="flash-zone">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>
    @endif

    {{-- Page content --}}
    <main class="page-content">
        @yield('content')
    </main>

    <footer class="page-footer">
        Hotel Internal Operations WIS &copy; {{ date('Y') }}
    </footer>

</div>

</body>
</html>
