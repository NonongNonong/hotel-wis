@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Stat cards row 1 --}}
<div class="row g-3 mb-3">

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(67,97,238,0.1); color:#4361ee;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Guests</div>
                <div class="stat-value">{{ $totalGuests }}</div>
                <div class="stat-sub">Registered guests</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(15,110,86,0.1); color:#0f6e56;">
                <i class="bi bi-door-open-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Available Rooms</div>
                <div class="stat-value">{{ $availableRooms }}</div>
                <div class="stat-sub">Out of {{ $totalRooms }} total</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(230,57,70,0.1); color:#e63946;">
                <i class="bi bi-door-closed-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Occupied Rooms</div>
                <div class="stat-value">{{ $occupiedRooms }}</div>
                <div class="stat-sub">Currently checked in</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(123,45,139,0.1); color:#7b2d8b;">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Employees</div>
                <div class="stat-value">{{ $totalEmployees }}</div>
                <div class="stat-sub">Active staff</div>
            </div>
        </div>
    </div>

</div>

{{-- Stat cards row 2 --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(0,119,182,0.1); color:#0077b6;">
                <i class="bi bi-calendar-check-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Reservations</div>
                <div class="stat-value">{{ $totalReservations }}</div>
                <div class="stat-sub">All time</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(244,162,97,0.15); color:#e07b2a;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Pending Requests</div>
                <div class="stat-value">{{ $pendingRequests }}</div>
                <div class="stat-sub">Awaiting assignment</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(42,157,143,0.1); color:#2a9d8f;">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Today's Check-ins</div>
                <div class="stat-value">{{ $todayCheckins }}</div>
                <div class="stat-sub">{{ now()->format('M d, Y') }}</div>
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
        <a href="{{ route('reservations.create') }}" class="btn btn-brand btn-sm">
            <i class="bi bi-calendar-plus me-1"></i> New Reservation
        </a>
        <a href="{{ route('checkinout.create') }}" class="btn btn-sm" style="background:#d1fae5; color:#065f46;">
            <i class="bi bi-box-arrow-in-right me-1"></i> Check-in Guest
        </a>
        <a href="{{ route('servicerequests.create') }}" class="btn btn-sm" style="background:#fef3c7; color:#92400e;">
            <i class="bi bi-clipboard2-plus me-1"></i> Service Request
        </a>
        <a href="{{ route('facilitybookings.create') }}" class="btn btn-sm" style="background:#dbeafe; color:#1e40af;">
            <i class="bi bi-bookmark-plus me-1"></i> Facility Booking
        </a>
        <a href="{{ route('schedules.create') }}" class="btn btn-sm" style="background:#ede9fe; color:#5b21b6;">
            <i class="bi bi-calendar3 me-1"></i> Add Schedule
        </a>
    </div>
</div>

@endsection
