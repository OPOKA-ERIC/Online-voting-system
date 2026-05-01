<x-guest-layout>
    <div class="text-center mb-4">
        <div class="mx-auto mb-3" style="width:52px;height:52px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-shield-lock-fill text-white fs-4"></i>
        </div>
        <h4 class="fw-bold text-white mb-1">Welcome Back</h4>
        <p style="color:rgba(255,255,255,0.45);font-size:.88rem;">Sign in to your account to continue</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-right:none;color:rgba(255,255,255,0.4);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" name="email" class="form-control"
                       style="border-left:none;"
                       placeholder="you@example.com"
                       value="{{ old('email') }}" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-right:none;color:rgba(255,255,255,0.4);">
                    <i class="bi bi-lock"></i>
                </span>
                <input id="password" type="password" name="password" class="form-control"
                       style="border-left:none;"
                       placeholder="••••••••" required>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <hr class="divider my-4">

    <p class="text-center mb-0" style="color:rgba(255,255,255,0.45);font-size:.88rem;">
        Don't have an account?
        <a href="{{ route('register') }}" class="auth-link fw-semibold ms-1">Create one</a>
    </p>
</x-guest-layout>
