@extends('layouts.admin')
@section('title', 'Check-in/out Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Check-in / Check-out Details</h5>
    <a href="{{ route('checkinout.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Guest Information</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Name</td>
                        <td>{{ $checkinout->guest->fname }} {{ $checkinout->guest->lname }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $checkinout->guest->email_add }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Mobile</td>
                        <td>{{ $checkinout->guest->mobile_num }}</td>
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
                        <td>{{ $checkinout->room->room_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Type</td>
                        <td>{{ $checkinout->room->room_type }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Base Rate</td>
                        <td>₱{{ number_format($checkinout->room->base_rate, 2) }}/night</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Service Requests --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                <small class="fw-semibold text-muted">Service Requests</small>
                <span class="badge bg-secondary">{{ $serviceRequests->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceRequests as $sr)
                        <tr>
                            <td>{{ $sr->id }}</td>
                            <td>{{ $sr->service?->service_name ?? '—' }}</td>
                            <td>{{ $sr->quantity }}</td>
                            <td>₱{{ number_format($sr->total_cost, 2) }}</td>
                            <td>{{ $sr->employee?->fname ?? '—' }}</td>
                            <td>
                                @php $badge = match($sr->status) {
                                    'Completed'   => 'bg-success',
                                    'Pending'     => 'bg-warning text-dark',
                                    'Assigned'    => 'bg-info text-dark',
                                    'In Progress' => 'bg-primary',
                                    'Cancelled'   => 'bg-danger',
                                    default       => 'bg-secondary',
                                }; @endphp
                                <span class="badge {{ $badge }}">{{ $sr->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No service requests.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($serviceRequests->count() > 0)
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-semibold">Service Total</td>
                            <td class="fw-semibold">₱{{ number_format($serviceRequests->sum('total_cost'), 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Facility Bookings --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                <small class="fw-semibold text-muted">Facility Bookings</small>
                <span class="badge bg-secondary">{{ $facilityBookings->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Facility</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facilityBookings as $fb)
                        <tr>
                            <td>{{ $fb->id }}</td>
                            <td>{{ $fb->facility?->facility_name ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($fb->booking_start)->format('M d, Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($fb->booking_end)->format('M d, Y h:i A') }}</td>
                            <td>{{ $fb->total_cost > 0 ? '₱'.number_format($fb->total_cost, 2) : 'Free' }}</td>
                            <td>
                                @php $badge = match($fb->status) {
                                    'Completed' => 'bg-success',
                                    'Confirmed' => 'bg-primary',
                                    'Pending'   => 'bg-warning text-dark',
                                    'Cancelled' => 'bg-danger',
                                    default     => 'bg-secondary',
                                }; @endphp
                                <span class="badge {{ $badge }}">{{ $fb->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No facility bookings.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($facilityBookings->where('total_cost', '>', 0)->count() > 0)
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-semibold">Facility Total</td>
                            <td class="fw-semibold">₱{{ number_format($facilityBookings->sum('total_cost'), 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Grand Total --}}
    @if($checkinout->status === 'Checked-out')
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-left: 3px solid #0f6e56 !important;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Grand Total (Room + Services + Facilities)</span>
                <span class="fw-bold fs-5" style="color:#0f6e56;">
                    ₱{{ number_format($checkinout->total_amount + $serviceRequests->sum('total_cost') + $facilityBookings->sum('total_cost'), 2) }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Transaction Summary</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:25%">Record ID</td>
                        <td>#{{ $checkinout->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Reservation ID</td>
                        <td>#{{ $checkinout->reservation_id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Check-in Time</td>
                        <td>{{ \Carbon\Carbon::parse($checkinout->actual_check_in)->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Check-out Time</td>
                        <td>
                            {{ $checkinout->actual_check_out
                                ? \Carbon\Carbon::parse($checkinout->actual_check_out)->format('F d, Y h:i A')
                                : '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Amount</td>
                        <td class="fw-semibold">₱{{ number_format($checkinout->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Payment Method</td>
                        <td>{{ $checkinout->payment_method ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($checkinout->status === 'Checked-in')
                                <span class="badge bg-success">Checked-in</span>
                            @else
                                <span class="badge bg-secondary">Checked-out</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Updated By</td>
                        <td>{{ $checkinout->last_update_by ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection