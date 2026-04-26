@extends('layouts.admin')
@section('title', 'New Reservation')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">New Reservation</h5>
    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Guest <span class="text-danger">*</span></label>
                    <select name="guest_id"
                            class="form-select @error('guest_id') is-invalid @enderror">
                        <option value="">-- Select Guest --</option>
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}"
                                {{ old('guest_id') == $guest->id ? 'selected' : '' }}>
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
                        <option value="">-- Select Available Room --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} —
                                {{ $room->room_type }} —
                                ₱{{ number_format($room->base_rate, 2) }}/night —
                                {{ $room->capacity }} pax
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
                           value="{{ old('check_in_date') }}"
                           min="{{ date('Y-m-d') }}">
                    @error('check_in_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Check-out Date <span class="text-danger">*</span></label>
                    <input type="date" name="check_out_date"
                           class="form-control @error('check_out_date') is-invalid @enderror"
                           value="{{ old('check_out_date') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('check_out_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="Pending"   {{ old('status') == 'Pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create Reservation</button>
                    <a href="{{ route('reservations.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection