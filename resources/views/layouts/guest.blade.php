<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VoteSecure') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        html, body { margin: 0; padding: 0; overflow-x: hidden; }
        body { background: #0f172a; display: flex; align-items: stretch; }

        /* ── Left Panel ── */
        .auth-left {
            width: 52%;
            background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 3rem;
        }
        .auth-left::before {
            content: '';
            position: absolute; top: -120px; right: -120px;
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }
        .auth-left::after {
            content: '';
            position: absolute; bottom: -100px; left: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }

        /* floating orb */
        .orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-18px); }
        }

        /* ── Right Panel ── */
        .auth-right {
            width: 48%;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            border-left: 1px solid rgba(255,255,255,0.06);
            overflow: hidden;
        }
        .auth-right::before {
            content: '';
            position: absolute; bottom: -150px; right: -150px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(245,158,11,0.07) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }

        .auth-form-wrap { width: 100%; max-width: 420px; }

        /* ── Form Elements ── */
        .form-label { color: rgba(255,255,255,0.65); font-size: .83rem; font-weight: 600; letter-spacing: .03em; text-transform: uppercase; margin-bottom: .4rem; }

        .auth-input-wrap { position: relative; }
        .auth-input-icon {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: rgba(255,255,255,0.3); pointer-events: none; font-size: .95rem;
            transition: color .2s;
        }
        .auth-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 12px;
            padding: .75rem 1rem .75rem 2.8rem;
            font-size: .92rem;
            outline: none;
            transition: all .2s;
        }
        .auth-input:focus {
            background: rgba(99,102,241,0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
        }
        .auth-input:focus + .auth-input-icon,
        .auth-input-wrap:focus-within .auth-input-icon { color: #a5b4fc; }
        .auth-input::placeholder { color: rgba(255,255,255,0.2); }

        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; color: #fff;
            padding: .85rem; border-radius: 12px;
            font-weight: 700; font-size: .95rem;
            cursor: pointer; transition: all .25s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            box-shadow: 0 4px 20px rgba(99,102,241,0.3);
        }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(99,102,241,0.45); }
        .btn-auth:active { transform: translateY(0); }

        .auth-link { color: #a5b4fc; text-decoration: none; font-size: .88rem; transition: color .2s; }
        .auth-link:hover { color: #c7d2fe; }

        .divider-line {
            display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0;
        }
        .divider-line::before, .divider-line::after {
            content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08);
        }
        .divider-line span { color: rgba(255,255,255,0.25); font-size: .78rem; white-space: nowrap; }

        .form-check-input { background-color: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .form-check-label { color: rgba(255,255,255,0.55); font-size: .85rem; }

        .alert-danger {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5; border-radius: 12px; font-size: .85rem; padding: .85rem 1rem;
        }
        .alert-success {
            background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25);
            color: #86efac; border-radius: 12px; font-size: .85rem; padding: .85rem 1rem;
        }

        /* ── Stat chips ── */
        .stat-chip {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 1rem 1.2rem;
            flex: 1;
        }

        /* ── Feature rows ── */
        .feature-row {
            display: flex; align-items: flex-start; gap: .9rem;
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .feature-row:last-child { border-bottom: none; }
        .feature-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 1rem;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

    <!-- Left Branded Panel -->
    <div class="auth-left">

        <!-- Floating orbs -->
        <div class="orb" style="width:180px;height:180px;background:rgba(99,102,241,0.1);top:20%;left:10%;animation-delay:0s;"></div>
        <div class="orb" style="width:100px;height:100px;background:rgba(6,182,212,0.08);top:55%;right:8%;animation-delay:2s;"></div>
        <div class="orb" style="width:60px;height:60px;background:rgba(245,158,11,0.1);bottom:20%;left:30%;animation-delay:4s;"></div>

        <!-- Logo -->
        <div class="d-flex align-items-center gap-3 mb-auto position-relative" style="z-index:1;">
            <div style="width:42px;height:42px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(99,102,241,0.4);">
                <i class="bi bi-shield-check text-white" style="font-size:1.1rem;"></i>
            </div>
            <div>
                <span class="fw-bold text-white" style="font-size:1.1rem;letter-spacing:-.01em;">VoteSecure</span>
                <p style="color:rgba(255,255,255,0.35);font-size:.72rem;margin:0;letter-spacing:.05em;text-transform:uppercase;">Online Voting System</p>
            </div>
        </div>

        <!-- Hero text -->
        <div class="position-relative my-5" style="z-index:1;">
            <div style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:50px;padding:.3rem .9rem;margin-bottom:1.5rem;">
                <span style="width:6px;height:6px;background:#4ade80;border-radius:50%;display:inline-block;"></span>
                <span style="color:#a5b4fc;font-size:.75rem;font-weight:600;letter-spacing:.05em;">SECURE · TRANSPARENT · TRUSTED</span>
            </div>
            <h1 class="fw-bold text-white mb-3" style="font-size:2.4rem;line-height:1.2;letter-spacing:-.02em;">
                Your Voice,<br>
                <span style="background:linear-gradient(135deg,#6366f1,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Securely Cast</span>
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:.95rem;line-height:1.7;max-width:380px;">
                Participate in elections with confidence. Every vote is encrypted, verified, and counted with full transparency.
            </p>
        </div>

        <!-- Stats -->
        <div class="d-flex gap-3 mb-4 position-relative" style="z-index:1;">
            <div class="stat-chip text-center">
                <i class="bi bi-shield-check" style="color:#6366f1;font-size:1.1rem;"></i>
                <p class="fw-bold text-white mb-0 mt-1" style="font-size:1.1rem;">100%</p>
                <p style="color:rgba(255,255,255,0.35);font-size:.72rem;margin:0;text-transform:uppercase;letter-spacing:.05em;">Secure</p>
            </div>
            <div class="stat-chip text-center">
                <i class="bi bi-eye-slash-fill" style="color:#06b6d4;font-size:1.1rem;"></i>
                <p class="fw-bold text-white mb-0 mt-1" style="font-size:1.1rem;">Private</p>
                <p style="color:rgba(255,255,255,0.35);font-size:.72rem;margin:0;text-transform:uppercase;letter-spacing:.05em;">Your Vote</p>
            </div>
            <div class="stat-chip text-center">
                <i class="bi bi-patch-check-fill" style="color:#22c55e;font-size:1.1rem;"></i>
                <p class="fw-bold text-white mb-0 mt-1" style="font-size:1.1rem;">Verified</p>
                <p style="color:rgba(255,255,255,0.35);font-size:.72rem;margin:0;text-transform:uppercase;letter-spacing:.05em;">Every Voter</p>
            </div>
        </div>

        <!-- Features -->
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:1rem 1.2rem;position:relative;z-index:1;">
            <div class="feature-row">
                <div class="feature-icon" style="background:rgba(99,102,241,0.15);">
                    <i class="bi bi-shield-lock-fill" style="color:#a5b4fc;"></i>
                </div>
                <div>
                    <p class="fw-semibold text-white mb-0" style="font-size:.88rem;">End-to-End Encryption</p>
                    <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Every vote is encrypted before storage.</p>
                </div>
            </div>
            <div class="feature-row">
                <div class="feature-icon" style="background:rgba(6,182,212,0.15);">
                    <i class="bi bi-person-check-fill" style="color:#67e8f9;"></i>
                </div>
                <div>
                    <p class="fw-semibold text-white mb-0" style="font-size:.88rem;">Identity Verification</p>
                    <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Voters are verified before casting votes.</p>
                </div>
            </div>
            <div class="feature-row">
                <div class="feature-icon" style="background:rgba(34,197,94,0.15);">
                    <i class="bi bi-bar-chart-fill" style="color:#4ade80;"></i>
                </div>
                <div>
                    <p class="fw-semibold text-white mb-0" style="font-size:.88rem;">Real-Time Results</p>
                    <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Live vote counts after you cast your vote.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-4 mb-0 position-relative" style="color:rgba(255,255,255,0.2);font-size:.75rem;z-index:1;">
            © {{ date('Y') }} VoteSecure — All rights reserved.
        </p>
    </div>

    <!-- Right Form Panel -->
    <div class="auth-right">
        <div class="auth-form-wrap">
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,0.4);font-size:.82rem;text-decoration:none;margin-bottom:2rem;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                <i class="bi bi-arrow-left"></i> Back to Home
            </a>
            {{ $slot }}
        </div>
        <p class="mt-5" style="color:rgba(255,255,255,0.2);font-size:.75rem;text-align:center;">
            © {{ date('Y') }} VoteSecure — All rights reserved.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
