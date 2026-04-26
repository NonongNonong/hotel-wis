@extends('layouts.admin')
@section('title', 'Employee Scheduling')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Employee Schedules</h5>
    <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary">
        + Add Schedule
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" action="{{ route('schedules.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="input-group" style="max-width: 260px;">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search employee, department..."
                   value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        </div>
        <select name="department" class="form-select form-select-sm"
                style="max-width: 180px;" onchange="this.form.submit()">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept }}"
                    {{ request('department') == $dept ? 'selected' : '' }}>
                    {{ $dept }}
                </option>
            @endforeach
        </select>
        <input type="date" name="date" class="form-control form-control-sm"
               style="max-width: 160px;"
               value="{{ request('date') }}"
               onchange="this.form.submit()">
        @if(request('search') || request('department') || request('date'))
            <a href="{{ route('schedules.index') }}"
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
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Work Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->id }}</td>
                    <td>
                        {{ $schedule->employee->fname }}
                        {{ $schedule->employee->lname }}
                    </td>
                    <td>{{ $schedule->department }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($schedule->work_date)->format('M d, Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($schedule->start_time)
                            ->diffInHours(\Carbon\Carbon::parse($schedule->end_time)) }}h
                    </td>
                    <td>{{ $schedule->created_by ?? '—' }}</td>
                    <td>
                        <a href="{{ route('schedules.show', $schedule) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="{{ route('schedules.edit', $schedule) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('schedules.destroy', $schedule) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this schedule?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No schedules found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $schedules->withQueryString()->links() }}
</div>

@endsection