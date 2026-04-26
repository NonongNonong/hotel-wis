@extends('layouts.admin')
@section('title', 'Service Request Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Service Request Details</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('servicerequests.edit', $servicerequest) }}"
           class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="{{ route('servicerequests.index') }}"
           class="btn btn-sm btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Guest and Room</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Guest</td>
                        <td>{{ $servicerequest->guest->fname }}
                            {{ $servicerequest->guest->lname }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Room</td>
                        <td>{{ $servicerequest->room->room_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Reservation</td>
                        <td>#{{ $servicerequest->reservation_id }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Service Details</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Service</td>
                        <td>{{ $servicerequest->service->service_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Quantity</td>
                        <td>{{ $servicerequest->quantity }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Cost</td>
                        <td class="fw-semibold">
                            ₱{{ number_format($servicerequest->total_cost, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Assigned To</td>
                        <td>
                            {{ $servicerequest->employee
                                ? $servicerequest->employee->fname . ' ' .
                                  $servicerequest->employee->lname
                                : '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($servicerequest->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($servicerequest->status === 'Assigned')
                                <span class="badge bg-info text-dark">Assigned</span>
                            @elseif($servicerequest->status === 'In Progress')
                                <span class="badge bg-primary">In Progress</span>
                            @elseif($servicerequest->status === 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Special Instructions</td>
                        <td>{{ $servicerequest->special_instructions ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created At</td>
                        <td>{{ $servicerequest->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection