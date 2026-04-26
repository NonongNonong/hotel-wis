@extends('layouts.admin')
@section('title', 'Facility Bookings')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Facility Bookings</h5>
    <a href="{{ route('facilitybookings.create') }}" class="btn btn-sm btn-primary">
        + New Booking
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" action="{{ route('facilitybookings.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="input-group" style="max-width: 280px;">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search guest, facility..."
                   value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        </div>
        <select name="status" class="form-select form-select-sm"
                style="max-width: 160px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Pending"    {{ request('status') == 'Pending'    ? 'selected' : '' }}>Pending</option>
            <option value="Confirmed"  {{ request('status') == 'Confirmed'  ? 'selected' : '' }}>Confirmed</option>
            <option value="Checked-in" {{ request('status') == 'Checked-in' ? 'selected' : '' }}>Checked-in</option>
            <option value="Completed"  {{ request('status') == 'Completed'  ? 'selected' : '' }}>Completed</option>
            <option value="Cancelled"  {{ request('status') == 'Cancelled'  ? 'selected' : '' }}>Cancelled</option>
        </select>
        @if(request('search') || request('status'))
            <a href="{{ route('facilitybookings.index') }}"
               class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Facility</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Total Cost</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>
                        {{ $booking->guest
                            ? $booking->guest->fname . ' ' . $booking->guest->lname
                            : '—' }}
                    </td>
                    <td>{{ $booking->facility->facility_name }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->booking_start)
                            ->format('M d, Y h:i A') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->booking_end)
                            ->format('M d, Y h:i A') }}
                    </td>
                    <td>
                        {{ $booking->total_cost > 0
                            ? '₱' . number_format($booking->total_cost, 2)
                            : 'Free' }}
                    </td>
                    <td>
                        @if($booking->rating)
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $booking->rating ? '★' : '☆' }}
                            @endfor
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->status === 'Confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($booking->status === 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status === 'Checked-in')
                            <span class="badge bg-primary">Checked-in</span>
                        @elseif($booking->status === 'Completed')
                            <span class="badge bg-secondary">Completed</span>
                        @elseif($booking->status === 'Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('facilitybookings.show', $booking) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="{{ route('facilitybookings.edit', $booking) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('facilitybookings.destroy', $booking) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this booking?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No facility bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $bookings->withQueryString()->links() }}
</div>

@endsection