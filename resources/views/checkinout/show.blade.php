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