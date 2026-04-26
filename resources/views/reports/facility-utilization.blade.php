@extends('layouts.admin')
@section('title', 'Facility Utilization Report')

@section('content')

<h5 class="fw-semibold mb-4">Facility Utilization Report</h5>

{{-- Date Filter --}}
<form method="GET" action="{{ route('reports.facility-utilization') }}" class="mb-4">
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

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Facility</th>
                    <th>Category</th>
                    <th>Total Bookings</th>
                    <th>Total Revenue</th>
                    <th>Avg Rating</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilities as $facility)
                <tr>
                    <td>{{ $facility->id }}</td>
                    <td>{{ $facility->facility_name }}</td>
                    <td>{{ $facility->facility_category }}</td>
                    <td>
                        <span class="badge bg-info text-dark">
                            {{ $facility->total_bookings ?? 0 }} booking/s
                        </span>
                    </td>
                    <td>₱{{ number_format($facility->total_revenue ?? 0, 2) }}</td>
                    <td>
                        @if($facility->avg_rating)
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= round($facility->avg_rating) ? '★' : '☆' }}
                            @endfor
                            <small class="text-muted">
                                ({{ number_format($facility->avg_rating, 1) }})
                            </small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($facility->status === 'Available')
                            <span class="badge bg-success">Available</span>
                        @elseif($facility->status === 'Under Maintenance')
                            <span class="badge bg-warning text-dark">Maintenance</span>
                        @else
                            <span class="badge bg-secondary">{{ $facility->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No facility data found.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-semibold">Totals</td>
                    <td class="fw-semibold">
                        {{ $facilities->sum('total_bookings') }} bookings
                    </td>
                    <td class="fw-semibold">
                        ₱{{ number_format($facilities->sum('total_revenue'), 2) }}
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection