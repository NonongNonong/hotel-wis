@extends('layouts.admin')
@section('title', 'Services')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Service Records</h5>
    <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary">
        + Add Service
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('services.index') }}" class="mb-3">
    <div class="input-group" style="max-width: 360px;">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search name, availability..."
               value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th>Last Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ Str::limit($service->description, 50, '...') }}</td>
                    <td>₱{{ number_format($service->price, 2) }}</td>
                    <td>
                        @if($service->availability === 'Available')
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-secondary">Unavailable</span>
                        @endif
                    </td>
                    <td>{{ $service->last_update_by ?? '—' }}</td>
                    <td>
                        <a href="{{ route('services.edit', $service) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('services.destroy', $service) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this service?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No services found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $services->withQueryString()->links() }}
</div>

@endsection