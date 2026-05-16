<x-guest-layout>

    <!-- Header -->
    <div class="mb-5">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;box-shadow:0 8px 24px rgba(99,102,241,0.35);">
            <i class="bi bi-shield-lock-fill text-white" style="font-size:1.4rem;"></i>
        </div>
        <h3 class="fw-bold text-white mb-1" style="letter-spacing:-.02em;">Welcome back</h3>
        <p style="color:rgba(255,255,255,0.4);font-size:.9rem;margin:0;">Sign in to your account to continue voting.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
            <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input"
                       placeholder="you@example.com"
                       value="{{ old('email') }}" required autofocus>
                <span class="auth-input-icon"><i class="bi bi-envelope"></i></span>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label mb-0">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link" style="font-size:.78rem;">Forgot password?</a>
                @endif
            </div>
            <div class="auth-input-wrap">
                <input id="password" type="password" name="password" class="auth-input"
                       placeholder="••••••••" required>
                <span class="auth-input-icon"><i class="bi bi-lock"></i></span>
                <button type="button" onclick="togglePw('password','toggle-pw-icon')"
                        style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:0;font-size:.95rem;">
                    <i id="toggle-pw-icon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <!-- Remember me -->
        <div class="d-flex align-items-center mb-5">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input me-2">
            <label for="remember_me" class="form-check-label">Keep me signed in</label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right"></i> Sign In
        </button>
    </form>

    <div style="height:1px;background:rgba(255,255,255,0.08);margin:1.5rem 0;"></div>

    <p class="text-center mb-0" style="color:rgba(255,255,255,0.4);font-size:.88rem;">
        Don't have an account?
        <a href="{{ route('register') }}" class="auth-link fw-semibold ms-1">Create one free</a>
    </p>

    <script>
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
    </script>

</x-guest-layout>
