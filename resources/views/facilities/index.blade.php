@extends('layouts.admin')
@section('title', 'Facilities')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Facility Records</h5>
    <a href="{{ route('facilities.create') }}" class="btn btn-sm btn-primary">
        + Add Facility
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('facilities.index') }}" class="mb-3">
    <div class="input-group" style="max-width: 360px;">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search name, category, status..."
               value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('facilities.index') }}" class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Facility Name</th>
                    <th>Category</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Reservable</th>
                    <th>Payment Required</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilities as $facility)
                <tr>
                    <td>{{ $facility->id }}</td>
                    <td>{{ $facility->facility_name }}</td>
                    <td>{{ $facility->facility_category }}</td>
                    <td>{{ $facility->capacity ? $facility->capacity . ' pax' : '—' }}</td>
                    <td>
                        {{ $facility->need_payment
                            ? '₱' . number_format($facility->price, 2)
                            : 'Free' }}
                    </td>
                    <td>
                        @if($facility->reservable)
                            <span class="badge bg-info text-dark">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        @if($facility->need_payment)
                            <span class="badge bg-warning text-dark">Required</span>
                        @else
                            <span class="badge bg-success">Free</span>
                        @endif
                    </td>
                    <td>
                        @if($facility->status === 'Available')
                            <span class="badge bg-success">Available</span>
                        @elseif($facility->status === 'Under Maintenance')
                            <span class="badge bg-warning text-dark">Maintenance</span>
                        @else
                            <span class="badge bg-secondary">{{ $facility->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('facilities.edit', $facility) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('facilities.destroy', $facility) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this facility?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No facilities found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $facilities->withQueryString()->links() }}
</div>

@endsection