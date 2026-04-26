@extends('layouts.admin')
@section('title', 'Edit Reservation')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Edit Reservation</h5>
    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('reservations.update', $reservation) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Guest <span class="text-danger">*</span></label>
                    <select name="guest_id"
                            class="form-select @error('guest_id') is-invalid @enderror">
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}"
                                {{ old('guest_id', $reservation->guest_id) == $guest->id ? 'selected' : '' }}>
                                {{ $guest->lname }}, {{ $guest->fname }}
                                ({{ $guest->email_add }})
                            </option>
                        @endforeach
                    </select>
                    @error('guest_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Room <span class="text-danger">*</span></label>
                    <select name="room_id"
                            class="form-select @error('room_id') is-invalid @enderror">
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} —
                                {{ $room->room_type }} —
                                ₱{{ number_format($room->base_rate, 2) }}/night
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Check-in Date <span class="text-danger">*</span></label>
                    <input type="date" name="check_in_date"
                           class="form-control @error('check_in_date') is-invalid @enderror"
                           value="{{ old('check_in_date', $reservation->check_in_date) }}">
                    @error('check_in_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Check-out Date <span class="text-danger">*</span></label>
                    <input type="date" name="check_out_date"
                           class="form-control @error('check_out_date') is-invalid @enderror"
                           value="{{ old('check_out_date', $reservation->check_out_date) }}">
                    @error('check_out_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Pending"   {{ old('status', $reservation->status) == 'Pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status', $reservation->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Cancelled" {{ old('status', $reservation->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Completed" {{ old('status', $reservation->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Reservation</button>
                    <a href="{{ route('reservations.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection