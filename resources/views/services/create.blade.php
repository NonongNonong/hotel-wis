@extends('layouts.admin')
@section('title', 'Add Service')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Add New Service</h5>
    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('services.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Service Name <span class="text-danger">*</span></label>
                    <input type="text" name="service_name"
                           class="form-control @error('service_name') is-invalid @enderror"
                           value="{{ old('service_name') }}"
                           placeholder="e.g. Housekeeping, Laundry, Room Service">
                    @error('service_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Brief description of the service...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
                    <input type="number" name="price" step="0.01"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}" min="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Availability <span class="text-danger">*</span></label>
                    <select name="availability"
                            class="form-select @error('availability') is-invalid @enderror">
                        <option value="Available"   {{ old('availability') == 'Available'   ? 'selected' : '' }}>Available</option>
                        <option value="Unavailable" {{ old('availability') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('availability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Service</button>
                    <a href="{{ route('services.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection