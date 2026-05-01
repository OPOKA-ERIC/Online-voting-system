<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Online Voting System') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: #0f172a;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        body::before {
            content: '';
            position: fixed; top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed; bottom: -200px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .auth-navbar {
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: 1rem 2rem;
        }
        .logo-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 7px;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%; max-width: 440px;
            backdrop-filter: blur(10px);
        }
        .form-label { color: rgba(255,255,255,0.7); font-size: .88rem; font-weight: 500; }
        .form-control {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            color: #fff; border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .9rem;
            transition: all .2s;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.25); }
        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }
        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .form-check-label { color: rgba(255,255,255,0.6); font-size: .88rem; }
        .btn-auth {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; color: #fff;
            padding: .7rem 1.5rem; border-radius: 10px;
            font-weight: 600; font-size: .95rem;
            transition: all .2s; width: 100%;
        }
        .btn-auth:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); color: #fff; }
        .auth-link { color: #a5b4fc; text-decoration: none; font-size: .88rem; }
        .auth-link:hover { color: #818cf8; }
        .divider { border-color: rgba(255,255,255,0.08); }
        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5; border-radius: 10px;
        }
        .alert-success {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            color: #86efac; border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="auth-navbar d-flex align-items-center justify-content-between">
        <a href="/" class="text-decoration-none d-flex align-items-center gap-2">
            <div class="logo-icon"><i class="bi bi-shield-check text-white" style="font-size:.85rem;"></i></div>
            <span class="fw-bold text-white">VoteSecure</span>
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-3" style="border-radius:8px;">Log In</a>
            <a href="{{ route('register') }}" class="btn btn-sm px-3" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:8px;">Register</a>
        </div>
    </nav>

    <!-- Content -->
    <div class="flex-grow-1 d-flex align-items-center justify-content-center py-5" style="position:relative;z-index:1;">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-3" style="color:rgba(255,255,255,0.25);font-size:.78rem;">
        © {{ date('Y') }} VoteSecure — Online Voting System
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
