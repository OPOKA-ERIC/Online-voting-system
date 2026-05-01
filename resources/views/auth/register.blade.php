<x-guest-layout>
    <div class="text-center mb-4">
        <div class="mx-auto mb-3" style="width:52px;height:52px;background:linear-gradient(135deg,#f59e0b,#ef4444);border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-person-plus-fill text-white fs-4"></i>
        </div>
        <h4 class="fw-bold text-white mb-1">Create Account</h4>
        <p style="color:rgba(255,255,255,0.45);font-size:.88rem;">Register to participate in elections</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-right:none;color:rgba(255,255,255,0.4);">
                    <i class="bi bi-person"></i>
                </span>
                <input id="name" type="text" name="name" class="form-control"
                       style="border-left:none;"
                       placeholder="John Doe"
                       value="{{ old('name') }}" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-right:none;color:rgba(255,255,255,0.4);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" name="email" class="form-control"
                       style="border-left:none;"
                       placeholder="you@example.com"
                       value="{{ old('email') }}" required>
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
                       placeholder="Min. 8 characters" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-right:none;color:rgba(255,255,255,0.4);">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" style="border-left:none;"
                       placeholder="Repeat password" required>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-person-check me-2"></i>Create Account
        </button>
    </form>

    <hr class="divider my-4">

    <p class="text-center mb-0" style="color:rgba(255,255,255,0.45);font-size:.88rem;">
        Already have an account?
        <a href="{{ route('login') }}" class="auth-link fw-semibold ms-1">Sign in</a>
    </p>
</x-guest-layout>
