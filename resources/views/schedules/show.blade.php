@extends('layouts.admin')
@section('title', 'Schedule Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Schedule Details</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('schedules.edit', $schedule) }}"
           class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="{{ route('schedules.index') }}"
           class="btn btn-sm btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <table class="table table-sm table-borderless mb-0">
            <tr>
                <td class="text-muted" style="width: 35%">Employee</td>
                <td>
                    {{ $schedule->employee->fname }}
                    {{ $schedule->employee->lname }}
                </td>
            </tr>
            <tr>
                <td class="text-muted">Role</td>
                <td>{{ $schedule->employee->role }}</td>
            </tr>
            <tr>
                <td class="text-muted">Department</td>
                <td>{{ $schedule->department }}</td>
            </tr>
            <tr>
                <td class="text-muted">Work Date</td>
                <td>
                    {{ \Carbon\Carbon::parse($schedule->work_date)->format('F d, Y') }}
                    ({{ \Carbon\Carbon::parse($schedule->work_date)->format('l') }})
                </td>
            </tr>
            <tr>
                <td class="text-muted">Start Time</td>
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <td class="text-muted">End Time</td>
                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <td class="text-muted">Total Hours</td>
                <td class="fw-semibold">
                    {{ \Carbon\Carbon::parse($schedule->start_time)
                        ->diffInHours(\Carbon\Carbon::parse($schedule->end_time)) }} hours
                </td>
            </tr>
            <tr>
                <td class="text-muted">Created By</td>
                <td>{{ $schedule->created_by ?? '—' }}</td>
            </tr>
            <tr>
                <td class="text-muted">Created At</td>
                <td>{{ $schedule->created_at->format('F d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection