@extends('layouts.guest')
@section('title', 'Book a Room')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('guest.reservations') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-semibold mb-0">Book a Room</h5>
</div>

<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card">
    <div class="card-header"><i class="bi bi-calendar-plus me-2 text-brand"></i>New Reservation</div>
    <div class="card-body">

        <form method="POST" action="{{ route('guest.reservations.store') }}" id="reservationForm">
            @csrf

            {{-- Room --}}
            <div class="mb-3">
                <label for="room_id" class="form-label">Select Room</label>
                @if($rooms->isEmpty())
                    <div class="alert alert-warning py-2 mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        No rooms are currently available. Please check back later.
                    </div>
                @else
                    <select id="room_id" name="room_id"
                            class="form-select @error('room_id') is-invalid @enderror"
                            required onchange="updateCost()">
                        <option value="">— Choose a room —</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                    data-rate="{{ $room->base_rate }}"
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} — {{ $room->room_type }}
                                (₱{{ number_format($room->base_rate, 2) }}/night)
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            {{-- Dates --}}
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="check_in_date" class="form-label">Check-in Date</label>
                    <input type="date" id="check_in_date" name="check_in_date"
                           class="form-control @error('check_in_date') is-invalid @enderror"
                           value="{{ old('check_in_date') }}"
                           min="{{ date('Y-m-d') }}"
                           required onchange="updateCost()">
                    @error('check_in_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="check_out_date" class="form-label">Check-out Date</label>
                    <input type="date" id="check_out_date" name="check_out_date"
                           class="form-control @error('check_out_date') is-invalid @enderror"
                           value="{{ old('check_out_date') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required onchange="updateCost()">
                    @error('check_out_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Cost preview --}}
            <div id="costPreview" class="alert alert-success py-2 mb-4 d-none">
                <i class="bi bi-receipt me-1"></i>
                <span id="costText"></span>
            </div>

            <button type="submit" class="btn btn-brand w-100" {{ $rooms->isEmpty() ? 'disabled' : '' }}>
                <i class="bi bi-check-circle me-1"></i> Submit Reservation
            </button>
        </form>

    </div>
</div>

</div>
</div>

<script>
function updateCost() {
    const roomSelect  = document.getElementById('room_id');
    const checkIn     = document.getElementById('check_in_date').value;
    const checkOut    = document.getElementById('check_out_date').value;
    const preview     = document.getElementById('costPreview');
    const costText    = document.getElementById('costText');

    if (!roomSelect.value || !checkIn || !checkOut) { preview.classList.add('d-none'); return; }

    const rate    = parseFloat(roomSelect.selectedOptions[0].dataset.rate);
    const inDate  = new Date(checkIn);
    const outDate = new Date(checkOut);
    const nights  = Math.round((outDate - inDate) / 86400000);

    if (nights <= 0) { preview.classList.add('d-none'); return; }

    const total = rate * nights;
    costText.textContent = nights + ' night' + (nights > 1 ? 's' : '') +
        ' × ₱' + rate.toLocaleString('en-PH', {minimumFractionDigits:2}) +
        ' = ₱' + total.toLocaleString('en-PH', {minimumFractionDigits:2}) + ' estimated total';
    preview.classList.remove('d-none');

    // keep check-out min in sync
    document.getElementById('check_out_date').min = new Date(inDate.getTime() + 86400000)
        .toISOString().split('T')[0];
}
</script>

@endsection
