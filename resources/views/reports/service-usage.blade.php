@extends('layouts.admin')
@section('title', 'Service Usage Report')

@section('content')

<h5 class="fw-semibold mb-4">Service Usage Report</h5>

{{-- Date Filter --}}
<form method="GET" action="{{ route('reports.service-usage') }}" class="mb-4">
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
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Total Requests</th>
                    <th>Total Quantity</th>
                    <th>Total Revenue</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>₱{{ number_format($service->price, 2) }}</td>
                    <td>{{ $service->total_requests ?? 0 }}</td>
                    <td>{{ $service->total_quantity ?? 0 }}</td>
                    <td>₱{{ number_format($service->total_revenue ?? 0, 2) }}</td>
                    <td>
                        @if($service->availability === 'Available')
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-secondary">Unavailable</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No service data found.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-semibold">Totals</td>
                    <td class="fw-semibold">{{ $services->sum('total_requests') }}</td>
                    <td class="fw-semibold">{{ $services->sum('total_quantity') }}</td>
                    <td class="fw-semibold">
                        ₱{{ number_format($services->sum('total_revenue'), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection