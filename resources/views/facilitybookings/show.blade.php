@extends('layouts.admin')
@section('title', 'Facility Booking Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Facility Booking Details</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('facilitybookings.edit', $facilitybooking) }}"
           class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="{{ route('facilitybookings.index') }}"
           class="btn btn-sm btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Facility Information</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Facility</td>
                        <td>{{ $facilitybooking->facility->facility_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Category</td>
                        <td>{{ $facilitybooking->facility->facility_category }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Capacity</td>
                        <td>{{ $facilitybooking->facility->capacity ?? '—' }} pax</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Price</td>
                        <td>
                            {{ $facilitybooking->facility->need_payment
                                ? '₱' . number_format($facilitybooking->facility->price, 2) . '/hr'
                                : 'Free' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Guest Information</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Guest</td>
                        <td>
                            {{ $facilitybooking->guest
                                ? $facilitybooking->guest->fname . ' ' .
                                  $facilitybooking->guest->lname
                                : '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Reservation</td>
                        <td>
                            {{ $facilitybooking->reservation_id
                                ? '#' . $facilitybooking->reservation_id
                                : '—' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Booking Summary</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:25%">Booking ID</td>
                        <td>#{{ $facilitybooking->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Start</td>
                        <td>
                            {{ \Carbon\Carbon::parse($facilitybooking->booking_start)
                                ->format('F d, Y h:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">End</td>
                        <td>
                            {{ \Carbon\Carbon::parse($facilitybooking->booking_end)
                                ->format('F d, Y h:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Duration</td>
                        <td>
                            {{ \Carbon\Carbon::parse($facilitybooking->booking_start)
                                ->diffInHours(\Carbon\Carbon::parse($facilitybooking->booking_end)) }}
                            hour/s
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Cost</td>
                        <td class="fw-semibold">
                            {{ $facilitybooking->total_cost > 0
                                ? '₱' . number_format($facilitybooking->total_cost, 2)
                                : 'Free' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($facilitybooking->status === 'Confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($facilitybooking->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($facilitybooking->status === 'Checked-in')
                                <span class="badge bg-primary">Checked-in</span>
                            @elseif($facilitybooking->status === 'Completed')
                                <span class="badge bg-secondary">Completed</span>
                            @elseif($facilitybooking->status === 'Cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Rating</td>
                        <td>
                            @if($facilitybooking->rating)
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $facilitybooking->rating ? '★' : '☆' }}
                                @endfor
                                ({{ $facilitybooking->rating }}/5)
                            @else
                                <span class="text-muted">Not yet rated</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Updated By</td>
                        <td>{{ $facilitybooking->last_update_by ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created At</td>
                        <td>
                            {{ $facilitybooking->created_at->format('F d, Y h:i A') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection