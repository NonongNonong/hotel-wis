@extends('layouts.admin')
@section('title', 'Add Schedule')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Add Employee Schedule</h5>
    <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('schedules.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Employee <span class="text-danger">*</span></label>
                    <select name="employee_id"
                            class="form-select @error('employee_id') is-invalid @enderror"
                            id="employeeSelect" onchange="setDepartment(this)">
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                    data-department="{{ $employee->department }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->lname }}, {{ $employee->fname }} —
                                {{ $employee->department }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <input type="text" name="department" id="departmentInput"
                           class="form-control @error('department') is-invalid @enderror"
                           value="{{ old('department') }}"
                           placeholder="Auto-filled from employee">
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Work Date <span class="text-danger">*</span></label>
                    <input type="date" name="work_date"
                           class="form-control @error('work_date') is-invalid @enderror"
                           value="{{ old('work_date') }}">
                    @error('work_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                    <input type="time" name="start_time"
                           class="form-control @error('start_time') is-invalid @enderror"
                           value="{{ old('start_time') }}">
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">End Time <span class="text-danger">*</span></label>
                    <input type="time" name="end_time"
                           class="form-control @error('end_time') is-invalid @enderror"
                           value="{{ old('end_time') }}">
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                    <a href="{{ route('schedules.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function setDepartment(select) {
    const selected = select.options[select.selectedIndex];
    document.getElementById('departmentInput').value =
        selected.dataset.department || '';
}
</script>

@endsection