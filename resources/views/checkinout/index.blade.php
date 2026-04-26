@extends('layouts.admin')
@section('title', 'Check-in / Check-out')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Check-in / Check-out</h5>
    <a href="{{ route('checkinout.create') }}" class="btn btn-sm btn-primary">
        + Check-in Guest
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" action="{{ route('checkinout.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search guest, room..."
                   value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
        </div>
        <select name="status" class="form-select form-select-sm"
                style="max-width: 160px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Checked-in"  {{ request('status') == 'Checked-in'  ? 'selected' : '' }}>Checked-in</option>
            <option value="Checked-out" {{ request('status') == 'Checked-out' ? 'selected' : '' }}>Checked-out</option>
        </select>
        @if(request('search') || request('status'))
            <a href="{{ route('checkinout.index') }}"
               class="btn btn-sm btn-outline-danger">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->guest->fname }} {{ $record->guest->lname }}</td>
                    <td>Room {{ $record->room->room_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->actual_check_in)->format('M d, Y h:i A') }}</td>
                    <td>
                        {{ $record->actual_check_out
                            ? \Carbon\Carbon::parse($record->actual_check_out)->format('M d, Y h:i A')
                            : '—' }}
                    </td>
                    <td>₱{{ number_format($record->total_amount, 2) }}</td>
                    <td>{{ $record->payment_method ?? '—' }}</td>
                    <td>
                        @if($record->status === 'Checked-in')
                            <span class="badge bg-success">Checked-in</span>
                        @else
                            <span class="badge bg-secondary">Checked-out</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('checkinout.show', $record) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                        @if($record->status === 'Checked-in')
                            <button class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#checkoutModal{{ $record->id }}">
                                Check-out
                            </button>

                            {{-- Checkout Modal --}}
                            <div class="modal fade" id="checkoutModal{{ $record->id }}"
                                 tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-semibold">
                                                Check-out — {{ $record->guest->fname }}
                                                {{ $record->guest->lname }}
                                            </h6>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST"
                                              action="{{ route('checkinout.checkout', $record) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3" style="font-size:0.9rem;">
                                                    Room {{ $record->room->room_number }} —
                                                    Checked in
                                                    {{ \Carbon\Carbon::parse($record->actual_check_in)->format('M d, Y') }}
                                                </p>
                                                <label class="form-label">
                                                    Payment Method
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="payment_method"
                                                        class="form-select" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Debit Card">Debit Card</option>
                                                    <option value="GCash">GCash</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    Confirm Check-out
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No check-in records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $records->withQueryString()->links() }}
</div>

@endsection