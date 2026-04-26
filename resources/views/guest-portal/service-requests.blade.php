@extends('layouts.guest')
@section('title', 'Service Requests')

@section('content')

<h5 class="fw-semibold mb-4">Service Requests</h5>

@if($activeReservation)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-semibold mb-3">Request a Service</h6>
        <form method="POST" action="{{ route('guest.service-requests.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Service <span class="text-danger">*</span></label>
                    <select name="service_id"
                            class="form-select @error('service_id') is-invalid @enderror">
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->service_name }} —
                                ₱{{ number_format($service->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity"
                           class="form-control @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity', 1) }}" min="1">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5">
                    <label class="form-label">Special Instructions</label>
                    <input type="text" name="special_instructions"
                           class="form-control"
                           placeholder="Any notes...">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Submit Request
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@else
<div class="alert alert-info mb-4" style="font-size:0.875rem;">
    You can only request services while you are checked in.
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Room</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->service->service_name }}</td>
                    <td>Room {{ $req->room->room_number }}</td>
                    <td>{{ $req->quantity }}</td>
                    <td>₱{{ number_format($req->total_cost, 2) }}</td>
                    <td>
                        {{ $req->employee
                            ? $req->employee->fname . ' ' . $req->employee->lname
                            : '—' }}
                    </td>
                    <td>
                        @if($req->status === 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($req->status === 'Assigned')
                            <span class="badge bg-info text-dark">Assigned</span>
                        @elseif($req->status === 'In Progress')
                            <span class="badge bg-primary">In Progress</span>
                        @elseif($req->status === 'Completed')
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </td>
                    <td>{{ $req->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        No service requests yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $requests->links() }}</div>

@endsection