@extends('layouts.admin')
@section('title', 'Check-in Guest')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Check-in Guest</h5>
    <a href="{{ route('checkinout.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('checkinout.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">
                        Select Reservation <span class="text-danger">*</span>
                    </label>
                    <select name="reservation_id"
                            class="form-select @error('reservation_id') is-invalid @enderror">
                        <option value="">-- Select Confirmed Reservation --</option>
                        @foreach($reservations as $reservation)
                            <option value="{{ $reservation->id }}"
                                {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}>
                                #{{ $reservation->id }} —
                                {{ $reservation->guest->lname }},
                                {{ $reservation->guest->fname }} —
                                Room {{ $reservation->room->room_number }} —
                                {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                                to
                                {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('reservation_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($reservations->isEmpty())
                        <small class="text-muted">
                            No confirmed reservations available for check-in.
                            <a href="{{ route('reservations.create') }}">Create one first.</a>
                        </small>
                    @endif
                </div>

                <div class="col-12">
                    <div class="alert alert-info mb-0" style="font-size: 0.85rem;">
                        Check-in time will be recorded automatically as the current date and time.
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"
                            {{ $reservations->isEmpty() ? 'disabled' : '' }}>
                        Confirm Check-in
                    </button>
                    <a href="{{ route('checkinout.index') }}"
                       class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection