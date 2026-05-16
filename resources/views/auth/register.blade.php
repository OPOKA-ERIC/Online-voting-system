<x-guest-layout>

    <!-- Header -->
    <div class="mb-5">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,#f59e0b,#ef4444);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;box-shadow:0 8px 24px rgba(245,158,11,0.3);">
            <i class="bi bi-person-plus-fill text-white" style="font-size:1.4rem;"></i>
        </div>
        <h3 class="fw-bold text-white mb-1" style="letter-spacing:-.02em;">Create your account</h3>
        <p style="color:rgba(255,255,255,0.4);font-size:.9rem;margin:0;">Register to participate in elections.</p>
    </div>

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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div class="mb-4">
            <label class="form-label">Full Name</label>
            <div class="auth-input-wrap">
                <input type="text" name="name" class="auth-input"
                       placeholder="Juan dela Cruz"
                       value="{{ old('name') }}" required autofocus>
                <span class="auth-input-icon"><i class="bi bi-person"></i></span>
            </div>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="auth-input-wrap">
                <input type="email" name="email" class="auth-input"
                       placeholder="you@example.com"
                       value="{{ old('email') }}" required>
                <span class="auth-input-icon"><i class="bi bi-envelope"></i></span>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label class="form-label">Password</label>
            <div class="auth-input-wrap">
                <input id="reg-password" type="password" name="password" class="auth-input"
                       placeholder="Min. 8 characters" required
                       oninput="checkStrength(this.value)">
                <span class="auth-input-icon"><i class="bi bi-lock"></i></span>
                <button type="button" onclick="togglePw('reg-password','toggle-reg-icon')"
                        style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:0;font-size:.95rem;">
                    <i id="toggle-reg-icon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <!-- Password strength meter -->
        <div class="mb-4">
            <div style="display:flex;gap:4px;margin-bottom:.3rem;">
                <div id="bar1" style="flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,0.08);transition:background .3s;"></div>
                <div id="bar2" style="flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,0.08);transition:background .3s;"></div>
                <div id="bar3" style="flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,0.08);transition:background .3s;"></div>
                <div id="bar4" style="flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,0.08);transition:background .3s;"></div>
            </div>
            <p id="strength-label" style="color:rgba(255,255,255,0.25);font-size:.75rem;margin:0;"></p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-5">
            <label class="form-label">Confirm Password</label>
            <div class="auth-input-wrap">
                <input id="reg-confirm" type="password" name="password_confirmation" class="auth-input"
                       placeholder="Repeat your password" required
                       oninput="checkMatch()">
                <span class="auth-input-icon"><i class="bi bi-lock-fill"></i></span>
                <span id="match-icon" style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);font-size:.95rem;display:none;"></span>
            </div>
        </div>

        <button type="submit" class="btn-auth" style="background:linear-gradient(135deg,#f59e0b,#ef4444);box-shadow:0 4px 20px rgba(245,158,11,0.3);">
            <i class="bi bi-person-check"></i> Create Account
        </button>
    </form>

    <div style="height:1px;background:rgba(255,255,255,0.08);margin:1.5rem 0;"></div>

    <p class="text-center mb-0" style="color:rgba(255,255,255,0.4);font-size:.88rem;">
        Already have an account?
        <a href="{{ route('login') }}" class="auth-link fw-semibold ms-1">Sign in</a>
    </p>

    <script>
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }

    function checkStrength(val) {
        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const colors = ['', '#ef4444', '#f59e0b', '#06b6d4', '#22c55e'];
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        const bars   = ['bar1','bar2','bar3','bar4'];

        bars.forEach((id, i) => {
            document.getElementById(id).style.background =
                i < score ? colors[score] : 'rgba(255,255,255,0.08)';
        });

        const lbl = document.getElementById('strength-label');
        lbl.textContent = val.length ? 'Password strength: ' + labels[score] : '';
        lbl.style.color = val.length ? colors[score] : 'rgba(255,255,255,0.25)';
    }

    function checkMatch() {
        const pw   = document.getElementById('reg-password').value;
        const conf = document.getElementById('reg-confirm').value;
        const icon = document.getElementById('match-icon');
        if (!conf) { icon.style.display = 'none'; return; }
        icon.style.display = 'inline';
        if (pw === conf) {
            icon.innerHTML = '<i class="bi bi-check-circle-fill" style="color:#22c55e;"></i>';
        } else {
            icon.innerHTML = '<i class="bi bi-x-circle-fill" style="color:#ef4444;"></i>';
        }
    }
    </script>

</x-guest-layout>
