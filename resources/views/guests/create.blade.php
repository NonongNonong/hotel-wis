@extends('layouts.admin')
@section('title', 'Add Guest')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Add New Guest</h5>
    <a href="{{ route('guests.index') }}" class="btn btn-sm btn-outline-secondary">
        Back
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('guests.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="fname"
                           class="form-control @error('fname') is-invalid @enderror"
                           value="{{ old('fname') }}">
                    @error('fname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lname"
                           class="form-control @error('lname') is-invalid @enderror"
                           value="{{ old('lname') }}">
                    @error('lname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_num"
                           class="form-control @error('mobile_num') is-invalid @enderror"
                           value="{{ old('mobile_num') }}">
                    @error('mobile_num')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email_add"
                           class="form-control @error('email_add') is-invalid @enderror"
                           value="{{ old('email_add') }}">
                    @error('email_add')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Age</label>
                    <input type="number" name="age"
                           class="form-control @error('age') is-invalid @enderror"
                           value="{{ old('age') }}">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Birthday</label>
                    <input type="date" name="birthday"
                           class="form-control @error('birthday') is-invalid @enderror"
                           value="{{ old('birthday') }}">
                    @error('birthday')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Guest</button>
                    <a href="{{ route('guests.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection