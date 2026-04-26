<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hotel WIS — {{ request()->routeIs('register') ? 'Create Account' : 'Sign In' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="login-page">
    <div class="login-card">

        <div class="login-logo">
            <div class="logo-box">
                <i class="bi bi-building"></i>
            </div>
            <h4>Hotel WIS</h4>
            <small>Internal Operations System</small>
        </div>

        {{ $slot }}

        <div class="login-footer">
            Hotel Internal Operations &copy; {{ date('Y') }}
        </div>
    </div>
</div>
</body>
</html>
