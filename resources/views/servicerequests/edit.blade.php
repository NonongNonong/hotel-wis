@extends('layouts.admin')
@section('title', 'Update Service Request')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Update Service Request</h5>
    <a href="{{ route('servicerequests.index') }}"
       class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">

        {{-- Read-only summary --}}
        <div class="alert alert-light border mb-4" style="font-size: 0.875rem;">
            <strong>Guest:</strong>
            {{ $servicerequest->guest->fname }} {{ $servicerequest->guest->lname }}
            &nbsp;|&nbsp;
            <strong>Room:</strong> {{ $servicerequest->room->room_number }}
            &nbsp;|&nbsp;
            <strong>Service:</strong> {{ $servicerequest->service->service_name }}
            &nbsp;|&nbsp;
            <strong>Qty:</strong> {{ $servicerequest->quantity }}
        </div>

        <form method="POST"
              action="{{ route('servicerequests.update', $servicerequest) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Assign Employee</label>
                    <select name="employee_id"
                            class="form-select @error('employee_id') is-invalid @enderror">
                        <option value="">-- Unassigned --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('employee_id', $servicerequest->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->fname }} {{ $employee->lname }} —
                                {{ $employee->department }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Pending"
                            {{ old('status', $servicerequest->status) == 'Pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="Assigned"
                            {{ old('status', $servicerequest->status) == 'Assigned'    ? 'selected' : '' }}>Assigned</option>
                        <option value="In Progress"
                            {{ old('status', $servicerequest->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed"
                            {{ old('status', $servicerequest->status) == 'Completed'   ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Request</button>
                    <a href="{{ route('servicerequests.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection