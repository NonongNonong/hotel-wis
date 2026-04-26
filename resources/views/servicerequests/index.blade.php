@extends('layouts.admin')
@section('title', 'Service Requests')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Service Requests</h5>
    <a href="{{ route('servicerequests.create') }}" class="btn btn-sm btn-primary">
        + New Request
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" action="{{ route('servicerequests.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search guest, service..."
                   value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        </div>
        <select name="status" class="form-select form-select-sm"
                style="max-width: 180px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Pending"     {{ request('status') == 'Pending'     ? 'selected' : '' }}>Pending</option>
            <option value="Assigned"    {{ request('status') == 'Assigned'    ? 'selected' : '' }}>Assigned</option>
            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Completed"   {{ request('status') == 'Completed'   ? 'selected' : '' }}>Completed</option>
        </select>
        @if(request('search') || request('status'))
            <a href="{{ route('servicerequests.index') }}"
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
                    <th>Service</th>
                    <th>Qty</th>
                    <th>Total Cost</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->guest->fname }} {{ $req->guest->lname }}</td>
                    <td>Room {{ $req->room->room_number }}</td>
                    <td>{{ $req->service->service_name }}</td>
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
                        @else
                            <span class="badge bg-secondary">{{ $req->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('servicerequests.show', $req) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="{{ route('servicerequests.edit', $req) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('servicerequests.destroy', $req) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this request?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No service requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $requests->withQueryString()->links() }}
</div>

@endsection