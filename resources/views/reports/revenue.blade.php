@extends('layouts.admin')
@section('title', 'Revenue Report')

@section('content')

<h5 class="fw-semibold mb-4">Revenue Report</h5>

{{-- Date Filter --}}
<form method="GET" action="{{ route('reports.revenue') }}" class="mb-4">
    <div class="d-flex gap-2 align-items-end flex-wrap">
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">From</label>
            <input type="date" name="from" class="form-control form-control-sm"
                   value="{{ $from }}">
        </div>
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">To</label>
            <input type="date" name="to" class="form-control form-control-sm"
                   value="{{ $to }}">
        </div>
        <button class="btn btn-sm btn-primary">Generate</button>
    </div>
</form>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Room Revenue</p>
                <h4 class="fw-bold mb-0">₱{{ number_format($roomRevenue, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Service Revenue</p>
                <h4 class="fw-bold mb-0">₱{{ number_format($serviceRevenue, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Facility Revenue</p>
                <h4 class="fw-bold mb-0">₱{{ number_format($facilityRevenue, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="border-left: 3px solid #0f6e56 !important;">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Revenue</p>
                <h4 class="fw-bold mb-0" style="color:#0f6e56;">
                    ₱{{ number_format($totalRevenue, 2) }}
                </h4>
            </div>
        </div>
    </div>
</div>

{{-- Room Revenue --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-2">
        <small class="fw-semibold text-muted">Room Revenue Breakdown</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-out Date</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($checkouts as $checkout)
                <tr>
                    <td>{{ $checkout->id }}</td>
                    <td>{{ $checkout->guest->fname }} {{ $checkout->guest->lname }}</td>
                    <td>Room {{ $checkout->room->room_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkout->actual_check_out)->format('M d, Y h:i A') }}</td>
                    <td>{{ $checkout->payment_method ?? '—' }}</td>
                    <td>₱{{ number_format($checkout->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No checkout records for this period.</td>
                </tr>
                @endforelse
            </tbody>
            @if($checkouts->count() > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="5" class="text-end fw-semibold">Room Total</td>
                    <td class="fw-semibold">₱{{ number_format($roomRevenue, 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Service Revenue --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-2">
        <small class="fw-semibold text-muted">Service Revenue Breakdown</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Service</th>
                    <th>Qty</th>
                    <th>Completed Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($serviceRequests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->guest->fname }} {{ $req->guest->lname }}</td>
                    <td>{{ $req->service->name ?? '—' }}</td>
                    <td>{{ $req->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->updated_at)->format('M d, Y h:i A') }}</td>
                    <td>₱{{ number_format($req->total_cost, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No completed service requests for this period.</td>
                </tr>
                @endforelse
            </tbody>
            @if($serviceRequests->count() > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="5" class="text-end fw-semibold">Service Total</td>
                    <td class="fw-semibold">₱{{ number_format($serviceRevenue, 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Facility Revenue --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-2">
        <small class="fw-semibold text-muted">Facility Revenue Breakdown</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Facility</th>
                    <th>Booking End</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilityBookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->guest->fname }} {{ $booking->guest->lname }}</td>
                    <td>{{ $booking->facility->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_end)->format('M d, Y h:i A') }}</td>
                    <td>₱{{ number_format($booking->total_cost, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No completed facility bookings for this period.</td>
                </tr>
                @endforelse
            </tbody>
            @if($facilityBookings->count() > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end fw-semibold">Facility Total</td>
                    <td class="fw-semibold">₱{{ number_format($facilityRevenue, 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection