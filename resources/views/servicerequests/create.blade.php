@extends('layouts.admin')
@section('title', 'New Service Request')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">New Service Request</h5>
    <a href="{{ route('servicerequests.index') }}"
       class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('servicerequests.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">
                        Active Reservation <span class="text-danger">*</span>
                    </label>
                    <select name="reservation_id"
                            class="form-select @error('reservation_id') is-invalid @enderror">
                        <option value="">-- Select Checked-in Reservation --</option>
                        @foreach($reservations as $reservation)
                            <option value="{{ $reservation->id }}"
                                {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}>
                                #{{ $reservation->id }} —
                                {{ $reservation->guest->lname }},
                                {{ $reservation->guest->fname }} —
                                Room {{ $reservation->room->room_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('reservation_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($reservations->isEmpty())
                        <small class="text-muted">
                            No active check-ins found.
                            <a href="{{ route('checkinout.create') }}">Check in a guest first.</a>
                        </small>
                    @endif
                </div>

                <div class="col-md-8">
                    <label class="form-label">Service <span class="text-danger">*</span></label>
                    <select name="service_id"
                            class="form-select @error('service_id') is-invalid @enderror">
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->service_name }} —
                                ₱{{ number_format($service->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity"
                           class="form-control @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity', 1) }}" min="1">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Assign Employee</label>
                    <select name="employee_id"
                            class="form-select @error('employee_id') is-invalid @enderror">
                        <option value="">-- Assign Later --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
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
                    <label class="form-label">Special Instructions</label>
                    <textarea name="special_instructions" rows="3"
                              class="form-control @error('special_instructions') is-invalid @enderror"
                              placeholder="Any special notes or instructions...">{{ old('special_instructions') }}</textarea>
                    @error('special_instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"
                            {{ $reservations->isEmpty() ? 'disabled' : '' }}>
                        Submit Request
                    </button>
                    <a href="{{ route('servicerequests.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection