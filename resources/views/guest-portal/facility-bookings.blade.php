@extends('layouts.guest')
@section('title', 'Facility Bookings')

@section('content')

<h5 class="fw-semibold mb-4">Facility Bookings</h5>

@if($activeReservation)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-semibold mb-3">Book a Facility</h6>
        <form method="POST" action="{{ route('guest.facility-bookings.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Facility <span class="text-danger">*</span></label>
                    <select name="facility_id"
                            class="form-select @error('facility_id') is-invalid @enderror">
                        <option value="">-- Select Facility --</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->id }}">
                                {{ $facility->facility_name }} —
                                {{ $facility->need_payment
                                    ? '₱' . number_format($facility->price, 2) . '/hr'
                                    : 'Free' }}
                            </option>
                        @endforeach
                    </select>
                    @error('facility_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Start <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="booking_start"
                           class="form-control @error('booking_start') is-invalid @enderror"
                           value="{{ old('booking_start') }}">
                    @error('booking_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">End <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="booking_end"
                           class="form-control @error('booking_end') is-invalid @enderror"
                           value="{{ old('booking_end') }}">
                    @error('booking_end')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Submit Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@else
<div class="alert alert-info mb-4" style="font-size:0.875rem;">
    You need a confirmed or active reservation to book a facility.
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Facility</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
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
                        @if($booking->status === 'Confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($booking->status === 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status === 'Completed')
                            <span class="badge bg-secondary">Completed</span>
                        @elseif($booking->status === 'Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No facility bookings yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $bookings->links() }}</div>

@endsection