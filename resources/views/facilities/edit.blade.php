@extends('layouts.admin')
@section('title', 'Edit Facility')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Edit Facility</h5>
    <a href="{{ route('facilities.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('facilities.update', $facility) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Facility Name <span class="text-danger">*</span></label>
                    <input type="text" name="facility_name"
                           class="form-control @error('facility_name') is-invalid @enderror"
                           value="{{ old('facility_name', $facility->facility_name) }}">
                    @error('facility_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="facility_category"
                            class="form-select @error('facility_category') is-invalid @enderror">
                        <option value="">-- Select Category --</option>
                        <option value="Recreation"  {{ old('facility_category', $facility->facility_category) == 'Recreation'  ? 'selected' : '' }}>Recreation</option>
                        <option value="Events"      {{ old('facility_category', $facility->facility_category) == 'Events'      ? 'selected' : '' }}>Events</option>
                        <option value="Dining"      {{ old('facility_category', $facility->facility_category) == 'Dining'      ? 'selected' : '' }}>Dining</option>
                        <option value="Wellness"    {{ old('facility_category', $facility->facility_category) == 'Wellness'    ? 'selected' : '' }}>Wellness</option>
                        <option value="Business"    {{ old('facility_category', $facility->facility_category) == 'Business'    ? 'selected' : '' }}>Business</option>
                        <option value="Other"       {{ old('facility_category', $facility->facility_category) == 'Other'       ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('facility_category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $facility->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Capacity (pax)</label>
                    <input type="number" name="capacity"
                           class="form-control @error('capacity') is-invalid @enderror"
                           value="{{ old('capacity', $facility->capacity) }}" min="1">
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Available"         {{ old('status', $facility->status) == 'Available'         ? 'selected' : '' }}>Available</option>
                        <option value="Under Maintenance" {{ old('status', $facility->status) == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        <option value="Unavailable"       {{ old('status', $facility->status) == 'Unavailable'       ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
                    <input type="number" name="price" step="0.01"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $facility->price) }}" min="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 d-flex align-items-end gap-4 pb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="reservable" id="reservable" value="1"
                               {{ old('reservable', $facility->reservable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="reservable">
                            Reservable
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="need_payment" id="need_payment" value="1"
                               {{ old('need_payment', $facility->need_payment) ? 'checked' : '' }}>
                        <label class="form-check-label" for="need_payment">
                            Payment Required
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Facility</button>
                    <a href="{{ route('facilities.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection