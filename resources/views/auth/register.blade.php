<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row g-2 mb-3">
            <div class="col">
                <label for="fname" class="form-label">First Name</label>
                <input id="fname" type="text" name="fname"
                       class="form-control @error('fname') is-invalid @enderror"
                       value="{{ old('fname') }}" required autofocus>
                @error('fname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="lname" class="form-label">Last Name</label>
                <input id="lname" type="text" name="lname"
                       class="form-control @error('lname') is-invalid @enderror"
                       value="{{ old('lname') }}" required>
                @error('lname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mobile_num" class="form-label">Mobile Number <span class="text-muted fw-normal">(optional)</span></label>
            <input id="mobile_num" type="text" name="mobile_num"
                   class="form-control @error('mobile_num') is-invalid @enderror"
                   value="{{ old('mobile_num') }}">
            @error('mobile_num')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-brand w-100">
            <i class="bi bi-person-plus me-1"></i> Create Account
        </button>

        <p class="text-center mt-3 mb-0" style="font-size:0.84rem; color:#6c757d;">
            Already have an account?
            <a href="{{ route('login') }}" style="color:var(--brand); text-decoration:none;">Sign in</a>
        </p>
    </form>
</x-guest-layout>
