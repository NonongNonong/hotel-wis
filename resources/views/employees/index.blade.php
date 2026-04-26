@extends('layouts.admin')
@section('title', 'Employees')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Employee Records</h5>
    <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
        + Add Employee
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('employees.index') }}" class="mb-3">
    <div class="input-group" style="max-width: 360px;">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search name, role, department..."
               value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-danger">Clear</a>
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
                    <th>Role</th>
                    <th>Department</th>
                    <th>Mobile</th>
                    <th>Hire Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->fname }} {{ $employee->lname }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->mobile_num }}</td>
                    <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') }}</td>
                    <td>
                        @if($employee->status === 'Active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employees.edit', $employee) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('employees.destroy', $employee) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this employee?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $employees->withQueryString()->links() }}
</div>

@endsection