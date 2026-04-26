@extends('layouts.admin')
@section('title', 'Reservations')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Reservations</h5>
    <a href="{{ route('reservations.create') }}" class="btn btn-sm btn-primary">
        + New Reservation
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" action="{{ route('reservations.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search guest, room..."
                   value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        </div>
        <select name="status" class="form-select form-select-sm" style="max-width: 160px;"
                onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Pending"   {{ request('status') == 'Pending'   ? 'selected' : '' }}>Pending</option>
            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
        @if(request('search') || request('status'))
            <a href="{{ route('reservations.index') }}"
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
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Nights</th>
                    <th>Base Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->guest->fname }} {{ $reservation->guest->lname }}</td>
                    <td>Room {{ $reservation->room->room_number }}
                        <small class="text-muted">({{ $reservation->room->room_type }})</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->check_in_date)
                            ->diffInDays($reservation->check_out_date) }} night/s
                    </td>
                    <td>₱{{ number_format($reservation->base_room_cost, 2) }}</td>
                    <td>
                        @if($reservation->status === 'Confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($reservation->status === 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($reservation->status === 'Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">{{ $reservation->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('reservations.show', $reservation) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="{{ route('reservations.edit', $reservation) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('reservations.destroy', $reservation) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Cancel this reservation?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No reservations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $reservations->withQueryString()->links() }}
</div>

@endsection