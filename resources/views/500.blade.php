@extends('layouts.admin')
@section('title', 'Server Error')

@section('content')
<div class="text-center py-5">
    <h1 class="fw-bold" style="font-size: 4rem; color: #dee2e6;">500</h1>
    <h5 class="fw-semibold mb-2">Something went wrong</h5>
    <p class="text-muted mb-4">An unexpected error occurred. Please try again.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
        Back to Dashboard
    </a>
</div>
@endsection