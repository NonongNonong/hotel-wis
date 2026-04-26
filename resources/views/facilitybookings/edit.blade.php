@extends('layouts.admin')
@section('title', 'Edit Facility Booking')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Edit Facility Booking</h5>
    <a href="{{ route('facilitybookings.index') }}"
       class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">

        <div class="alert alert-light border mb-4" style="font-size: 0.875rem;">
            <strong>Facility:</strong>
            {{ $facilitybooking->facility->facility_name }}
            &nbsp;|&nbsp;
            <strong>Guest:</strong>
            {{ $facilitybooking->guest
                ? $facilitybooking->guest->fname . ' ' . $facilitybooking->guest->lname
                : '—' }}
        </div>

        <form method="POST"
              action="{{ route('facilitybookings.update', $facilitybooking) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Booking Start <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="booking_start"
                           class="form-control @error('booking_start') is-invalid @enderror"
                           value="{{ old('booking_start',
                               \Carbon\Carbon::parse($facilitybooking->booking_start)
                                   ->format('Y-m-d\TH:i')) }}">
                    @error('booking_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Booking End <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="booking_end"
                           class="form-control @error('booking_end') is-invalid @enderror"
                           value="{{ old('booking_end',
                               \Carbon\Carbon::parse($facilitybooking->booking_end)
                                   ->format('Y-m-d\TH:i')) }}">
                    @error('booking_end')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Pending"    {{ old('status', $facilitybooking->status) == 'Pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed"  {{ old('status', $facilitybooking->status) == 'Confirmed'  ? 'selected' : '' }}>Confirmed</option>
                        <option value="Checked-in" {{ old('status', $facilitybooking->status) == 'Checked-in' ? 'selected' : '' }}>Checked-in</option>
                        <option value="Completed"  {{ old('status', $facilitybooking->status) == 'Completed'  ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled"  {{ old('status', $facilitybooking->status) == 'Cancelled'  ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Rating (1–5)</label>
                    <select name="rating"
                            class="form-select @error('rating') is-invalid @enderror">
                        <option value="">— No Rating —</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('rating', $facilitybooking->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Booking</button>
                    <a href="{{ route('facilitybookings.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection