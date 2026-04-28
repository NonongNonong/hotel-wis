@extends('layouts.admin')
@section('title', 'New Facility Booking')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">New Facility Booking</h5>
    <a href="{{ route('facilitybookings.index') }}"
       class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
    <div class="card-body">
        <form method="POST" action="{{ route('facilitybookings.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Facility <span class="text-danger">*</span></label>
                    <select name="facility_id"
                            class="form-select @error('facility_id') is-invalid @enderror">
                        <option value="">-- Select Facility --</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->id }}"
                                {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                {{ $facility->facility_name }} —
                                {{ $facility->facility_category }} —
                                {{ $facility->need_payment
                                    ? '₱' . number_format($facility->price, 2) . '/hr'
                                    : 'Free' }}
                            </option>
                        @endforeach
                    </select>
                    @error('facility_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Link to Reservation <small class="text-muted">(sets guest automatically)</small></label>
                    <select name="reservation_id" id="reservation_id"
                            class="form-select @error('reservation_id') is-invalid @enderror"
                            onchange="toggleGuestField()">
                        <option value="">-- No Reservation --</option>
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
                </div>

                <div class="col-12" id="guestField" {{ old('reservation_id') ? 'style=display:none' : '' }}>
                    <label class="form-label">Guest <span class="text-danger">*</span> <small class="text-muted">(required when no reservation selected)</small></label>
                    <select name="guest_id" class="form-select @error('guest_id') is-invalid @enderror">
                        <option value="">-- Select Guest --</option>
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>
                                {{ $guest->lname }}, {{ $guest->fname }}
                            </option>
                        @endforeach
                    </select>
                    @error('guest_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Booking Start <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="booking_start"
                           class="form-control @error('booking_start') is-invalid @enderror"
                           value="{{ old('booking_start') }}">
                    @error('booking_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Booking End <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="booking_end"
                           class="form-control @error('booking_end') is-invalid @enderror"
                           value="{{ old('booking_end') }}">
                    @error('booking_end')
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
                    <button type="submit" class="btn btn-primary">Create Booking</button>
                    <a href="{{ route('facilitybookings.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function toggleGuestField() {
    const hasReservation = document.getElementById('reservation_id').value;
    document.getElementById('guestField').style.display = hasReservation ? 'none' : '';
}
</script>

@endsection