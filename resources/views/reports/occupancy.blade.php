@extends('layouts.admin')
@section('title', 'Occupancy Report')

@section('content')

<h5 class="fw-semibold mb-4">Occupancy Report</h5>

{{-- Date Filter --}}
<form method="GET" action="{{ route('reports.occupancy') }}" class="mb-4">
    <div class="d-flex gap-2 align-items-end flex-wrap">
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">From</label>
            <input type="date" name="from" class="form-control form-control-sm"
                   value="{{ $from }}">
        </div>
        <div>
            <label class="form-label mb-1" style="font-size:0.8rem;">To</label>
            <input type="date" name="to" class="form-control form-control-sm"
                   value="{{ $to }}">
        </div>
        <button class="btn btn-sm btn-primary">Generate</button>
    </div>
</form>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Rooms</p>
                <h3 class="fw-bold mb-0">{{ $totalRooms }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Currently Occupied</p>
                <h3 class="fw-bold mb-0">{{ $occupiedCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Occupancy Rate</p>
                <h3 class="fw-bold mb-0">{{ $occupancyRate }}%</h3>
            </div>
        </div>
    </div>
</div>

{{-- Records Table --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->guest->fname }} {{ $record->guest->lname }}</td>
                    <td>Room {{ $record->room->room_number }}</td>
                    <td>{{ $record->room->room_type }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($record->actual_check_in)
                            ->format('M d, Y h:i A') }}
                    </td>
                    <td>
                        {{ $record->actual_check_out
                            ? \Carbon\Carbon::parse($record->actual_check_out)
                                ->format('M d, Y h:i A')
                            : '—' }}
                    </td>
                    <td>
                        @if($record->status === 'Checked-in')
                            <span class="badge bg-success">Checked-in</span>
                        @else
                            <span class="badge bg-secondary">Checked-out</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No occupancy records for this period.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection