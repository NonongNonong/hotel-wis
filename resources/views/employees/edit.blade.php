@extends('layouts.admin')
@section('title', 'Edit Employee')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Edit Employee</h5>
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="fname"
                           class="form-control @error('fname') is-invalid @enderror"
                           value="{{ old('fname', $employee->fname) }}">
                    @error('fname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lname"
                           class="form-control @error('lname') is-invalid @enderror"
                           value="{{ old('lname', $employee->lname) }}">
                    @error('lname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <input type="text" name="role"
                           class="form-control @error('role') is-invalid @enderror"
                           value="{{ old('role', $employee->role) }}">
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <select name="department"
                            class="form-select @error('department') is-invalid @enderror">
                        <option value="">-- Select Department --</option>
                        <option value="Front Desk"        {{ old('department', $employee->department) == 'Front Desk'        ? 'selected' : '' }}>Front Desk</option>
                        <option value="Housekeeping"      {{ old('department', $employee->department) == 'Housekeeping'      ? 'selected' : '' }}>Housekeeping</option>
                        <option value="Food and Beverage" {{ old('department', $employee->department) == 'Food and Beverage' ? 'selected' : '' }}>Food and Beverage</option>
                        <option value="Maintenance"       {{ old('department', $employee->department) == 'Maintenance'       ? 'selected' : '' }}>Maintenance</option>
                        <option value="Concierge"         {{ old('department', $employee->department) == 'Concierge'         ? 'selected' : '' }}>Concierge</option>
                        <option value="Security"          {{ old('department', $employee->department) == 'Security'          ? 'selected' : '' }}>Security</option>
                        <option value="Management"        {{ old('department', $employee->department) == 'Management'        ? 'selected' : '' }}>Management</option>
                    </select>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_num"
                           class="form-control @error('mobile_num') is-invalid @enderror"
                           value="{{ old('mobile_num', $employee->mobile_num) }}">
                    @error('mobile_num')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email_add"
                           class="form-control @error('email_add') is-invalid @enderror"
                           value="{{ old('email_add', $employee->email_add) }}">
                    @error('email_add')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Age</label>
                    <input type="number" name="age"
                           class="form-control @error('age') is-invalid @enderror"
                           value="{{ old('age', $employee->age) }}" min="1">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Birthday</label>
                    <input type="date" name="birthday"
                           class="form-control @error('birthday') is-invalid @enderror"
                           value="{{ old('birthday', $employee->birthday) }}">
                    @error('birthday')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hire Date <span class="text-danger">*</span></label>
                    <input type="date" name="hire_date"
                           class="form-control @error('hire_date') is-invalid @enderror"
                           value="{{ old('hire_date', $employee->hire_date) }}">
                    @error('hire_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Active"   {{ old('status', $employee->status) == 'Active'   ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                    <a href="{{ route('employees.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection