@extends('layouts.admin')
@section('title', 'Page Not Found')

@section('content')
<div class="text-center py-5">
    <h1 class="fw-bold" style="font-size: 4rem; color: #dee2e6;">404</h1>
    <h5 class="fw-semibold mb-2">Page not found</h5>
    <p class="text-muted mb-4">The page you are looking for does not exist.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
        Back to Dashboard
    </a>
</div>
@endsection