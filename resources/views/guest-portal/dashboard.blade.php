@extends('layouts.guest')
@section('title', 'My Dashboard')

@section('content')

<div class="mb-4">
    <h5 class="fw-semibold mb-0">Welcome back, {{ $guest->fname }}!</h5>
    <small class="text-muted">Here is a summary of your stay.</small>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(0,119,182,0.1); color:#0077b6;">
                <i class="bi bi-calendar-check-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Reservations</div>
                <div class="stat-value">{{ $totalReservations }}</div>
                <div class="stat-sub">All reservations</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(15,110,86,0.1); color:#0f6e56;">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Active Reservations</div>
                <div class="stat-value">{{ $activeReservations }}</div>
                <div class="stat-sub">Currently active</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(244,162,97,0.15); color:#e07b2a;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Pending Services</div>
                <div class="stat-value">{{ $pendingServices }}</div>
                <div class="stat-sub">Awaiting action</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(67,97,238,0.1); color:#4361ee;">
                <i class="bi bi-bookmark-check-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Facility Bookings</div>
                <div class="stat-value">{{ $totalFacilities }}</div>
                <div class="stat-sub">Total bookings</div>
            </div>
        </div>
    </div>

</div>

{{-- Quick actions --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-lightning-charge-fill text-warning"></i> Quick Actions
    </div>
    <div class="card-body d-flex gap-2 flex-wrap">
        <a href="{{ route('guest.reservations') }}" class="btn btn-brand btn-sm">
            <i class="bi bi-calendar-check me-1"></i> View Reservations
        </a>
        <a href="{{ route('guest.reservations.create') }}" class="btn btn-sm" style="background:#d1fae5; color:#065f46;">
            <i class="bi bi-plus-circle me-1"></i> Book a Room
        </a>
        <a href="{{ route('guest.service-requests') }}" class="btn btn-sm" style="background:#fef3c7; color:#92400e;">
            <i class="bi bi-clipboard2-plus me-1"></i> Request a Service
        </a>
        <a href="{{ route('guest.facility-bookings') }}" class="btn btn-sm" style="background:#dbeafe; color:#1e40af;">
            <i class="bi bi-bookmark-plus me-1"></i> Book a Facility
        </a>
    </div>
</div>

@endsection
