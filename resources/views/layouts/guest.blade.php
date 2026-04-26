<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel WIS — @yield('title', 'Guest Portal')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- ── SIDEBAR ─────────────────────────────────────────────── --}}
<aside class="sidebar">

    <a class="sidebar-brand" href="{{ route('guest.dashboard') }}">
        <div class="brand-icon"><i class="bi bi-building"></i></div>
        <div>
            <span class="brand-name">Hotel WIS</span>
            <span class="brand-sub">Guest Portal</span>
        </div>
    </a>

    {{-- Guest info --}}
    <div style="padding: 0.85rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.07);">
        <div style="font-size:0.68rem; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Logged in as</div>
        <div style="font-size:0.855rem; color:#fff; font-weight:500;">
            @if(auth()->check() && auth()->user()->guestProfile)
                {{ auth()->user()->guestProfile->fname }} {{ auth()->user()->guestProfile->lname }}
            @else
                Guest
            @endif
        </div>
    </div>

    <nav class="sidebar-nav">

        <a href="{{ route('guest.dashboard') }}"
           class="nav-link {{ request()->routeIs('guest.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">My Stay</div>

        <a href="{{ route('guest.reservations') }}"
           class="nav-link {{ request()->routeIs('guest.reservations') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> My Reservations
        </a>

        <a href="{{ route('guest.service-requests') }}"
           class="nav-link {{ request()->routeIs('guest.service-requests') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-check"></i> Service Requests
        </a>

        <a href="{{ route('guest.facility-bookings') }}"
           class="nav-link {{ request()->routeIs('guest.facility-bookings') ? 'active' : '' }}">
            <i class="bi bi-bookmark-check"></i> Facility Bookings
        </a>

    </nav>

    <div class="sidebar-footer">
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
        <span class="topbar-title">@yield('title', 'Guest Portal')</span>
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
