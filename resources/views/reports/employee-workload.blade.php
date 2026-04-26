@extends('layouts.admin')
@section('title', 'Employee Workload Report')

@section('content')

<h5 class="fw-semibold mb-4">Employee Workload Report</h5>

{{-- Date Filter --}}
<form method="GET" action="{{ route('reports.employee-workload') }}" class="mb-4">
    <div class="d-flex gap-2 align-items-end flex-wrap">
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">From</label>
            <input type="date" name="from" class="form-control form-control-sm"
                   value="{{ $from }}">
        </div>
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">To</label>
            <input type="date" name="to" class="form-control form-control-sm"
                   value="{{ $to }}">
        </div>
        <button class="btn btn-sm btn-primary">Generate</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Total Shifts</th>
                    <th>Services Handled</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->fname }} {{ $employee->lname }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>
                        <span class="badge bg-info text-dark">
                            {{ $employee->total_shifts }} shift/s
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $employee->total_services }} service/s
                        </span>
                    </td>
                    <td>
                        @if($employee->status === 'Active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No employee data found.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end fw-semibold">Totals</td>
                    <td class="fw-semibold">{{ $employees->sum('total_shifts') }} shifts</td>
                    <td class="fw-semibold">{{ $employees->sum('total_services') }} services</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection