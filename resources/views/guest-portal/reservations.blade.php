@extends('layouts.guest')
@section('title', 'My Reservations')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">My Reservations</h5>
    <a href="{{ route('guest.reservations.create') }}" class="btn btn-brand btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Book a Room
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Nights</th>
                    <th>Base Cost</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>
                        Room {{ $reservation->room->room_number }}
                        <small class="text-muted">({{ $reservation->room->room_type }})</small>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->check_in_date)
                            ->format('M d, Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->check_out_date)
                            ->format('M d, Y') }}
                    </td>
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
                        @elseif($reservation->status === 'Checked-in')
                            <span class="badge bg-primary">Checked-in</span>
                        @elseif($reservation->status === 'Completed')
                            <span class="badge bg-secondary">Completed</span>
                        @elseif($reservation->status === 'Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No reservations found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $reservations->links() }}</div>

@endsection