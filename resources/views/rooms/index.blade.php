@extends('layouts.admin')
@section('title', 'Rooms')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Room Records</h5>
    <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary">
        + Add Room
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('rooms.index') }}" class="mb-3">
    <div class="input-group" style="max-width: 360px;">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search room number, type, status..."
               value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Room No.</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Base Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->room_type }}</td>
                    <td>{{ $room->capacity }} pax</td>
                    <td>₱{{ number_format($room->base_rate, 2) }}</td>
                    <td>
                        @if($room->status === 'Available')
                            <span class="badge bg-success">Available</span>
                        @elseif($room->status === 'Occupied')
                            <span class="badge bg-danger">Occupied</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $room->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('rooms.edit', $room) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('rooms.destroy', $room) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this room?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No rooms found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $rooms->withQueryString()->links() }}
</div>

@endsection