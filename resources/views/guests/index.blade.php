@extends('layouts.admin')
@section('title', 'Guests')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Guest Records</h5>
    <a href="{{ route('guests.create') }}" class="btn btn-sm btn-primary">
        + Add Guest
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('guests.index') }}" class="mb-3">
    <div class="input-group" style="max-width: 360px;">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search name, email, mobile..."
               value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('guests.index') }}" class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                <tr>
                    <td>{{ $guest->id }}</td>
                    <td>{{ $guest->fname }} {{ $guest->lname }}</td>
                    <td>{{ $guest->mobile_num }}</td>
                    <td>{{ $guest->email_add }}</td>
                    <td>{{ $guest->age ?? '—' }}</td>
                    <td>{{ $guest->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('guests.edit', $guest) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('guests.destroy', $guest) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this guest?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No guests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $guests->withQueryString()->links() }}
</div>

@endsection