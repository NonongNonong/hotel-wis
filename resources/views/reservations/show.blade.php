@extends('layouts.admin')
@section('title', 'Reservation Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Reservation Details</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('reservations.edit', $reservation) }}"
           class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="{{ route('reservations.index') }}"
           class="btn btn-sm btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Guest Information</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Name</td>
                        <td>{{ $reservation->guest->fname }} {{ $reservation->guest->lname }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $reservation->guest->email_add }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Mobile</td>
                        <td>{{ $reservation->guest->mobile_num }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Room Information</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Room</td>
                        <td>{{ $reservation->room->room_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Type</td>
                        <td>{{ $reservation->room->room_type }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Base Rate</td>
                        <td>₱{{ number_format($reservation->room->base_rate, 2) }}/night</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Reservation Summary</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:25%">Reservation ID</td>
                        <td>#{{ $reservation->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Check-in</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Check-out</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nights</td>
                        <td>
                            {{ \Carbon\Carbon::parse($reservation->check_in_date)
                                ->diffInDays($reservation->check_out_date) }} night/s
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Base Room Cost</td>
                        <td class="fw-semibold">₱{{ number_format($reservation->base_room_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
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
                    </tr>
                    <tr>
                        <td class="text-muted">Created By</td>
                        <td>{{ $reservation->created_by ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created At</td>
                        <td>{{ $reservation->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection