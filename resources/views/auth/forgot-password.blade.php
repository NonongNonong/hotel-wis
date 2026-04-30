<x-guest-layout>
    <p class="text-muted mb-4" style="font-size:0.855rem;">
        Forgot your password? Enter your email and we'll send you a reset link.
    </p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-brand w-100">
            <i class="bi bi-envelope me-1"></i> Email Password Reset Link
        </button>

        <p class="text-center mt-3 mb-0" style="font-size:0.84rem; color:#6c757d;">
            <a href="{{ route('login') }}" style="color:var(--brand); text-decoration:none;">
                Back to Sign In
            </a>
        </p>
    </form>
</x-guest-layout>
