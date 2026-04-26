<x-guest-layout>
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label fw-normal text-muted" for="remember_me" style="font-size:0.84rem;">
                    Remember me
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.84rem; color:var(--brand); text-decoration:none;">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-brand w-100">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>

        @if (Route::has('register'))
            <p class="text-center mt-3 mb-0" style="font-size:0.84rem; color:#6c757d;">
                Don't have an account?
                <a href="{{ route('register') }}" style="color:var(--brand); text-decoration:none;">Create one</a>
            </p>
        @endif
    </form>
</x-guest-layout>
