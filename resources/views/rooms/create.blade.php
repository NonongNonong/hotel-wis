@extends('layouts.admin')
@section('title', 'Add Room')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Add New Room</h5>
    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Room Number <span class="text-danger">*</span></label>
                    <input type="text" name="room_number"
                           class="form-control @error('room_number') is-invalid @enderror"
                           value="{{ old('room_number') }}">
                    @error('room_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type"
                            class="form-select @error('room_type') is-invalid @enderror">
                        <option value="">-- Select Type --</option>
                        <option value="Standard" {{ old('room_type') == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Deluxe"   {{ old('room_type') == 'Deluxe'   ? 'selected' : '' }}>Deluxe</option>
                        <option value="Suite"    {{ old('room_type') == 'Suite'    ? 'selected' : '' }}>Suite</option>
                        <option value="Family"   {{ old('room_type') == 'Family'   ? 'selected' : '' }}>Family</option>
                    </select>
                    @error('room_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Capacity <span class="text-danger">*</span></label>
                    <input type="number" name="capacity"
                           class="form-control @error('capacity') is-invalid @enderror"
                           value="{{ old('capacity') }}" min="1">
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Base Rate (₱) <span class="text-danger">*</span></label>
                    <input type="number" name="base_rate" step="0.01"
                           class="form-control @error('base_rate') is-invalid @enderror"
                           value="{{ old('base_rate') }}" min="0">
                    @error('base_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Occupied"  {{ old('status') == 'Occupied'  ? 'selected' : '' }}>Occupied</option>
                        <option value="Reserved"  {{ old('status') == 'Reserved'  ? 'selected' : '' }}>Reserved</option>
                        <option value="Under Maintenance" {{ old('status') == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Room Details</label>
                    <textarea name="room_details" rows="3"
                              class="form-control @error('room_details') is-invalid @enderror">{{ old('room_details') }}</textarea>
                    @error('room_details')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Room</button>
                    <a href="{{ route('rooms.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection