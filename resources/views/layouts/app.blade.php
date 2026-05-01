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
        body { background: #0f172a; color: #fff; min-height: 100vh; }

        /* Navbar */
        .voter-navbar {
            background: rgba(15,23,42,0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: .85rem 0;
            position: sticky; top: 0; z-index: 100;
        }
        .logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .voter-navbar .nav-link {
            color: rgba(255,255,255,0.6);
            font-size: .88rem; font-weight: 500;
            padding: .4rem .8rem; border-radius: 8px;
            transition: all .2s;
        }
        .voter-navbar .nav-link:hover,
        .voter-navbar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .user-badge {
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            color: #a5b4fc;
            padding: .35rem .9rem; border-radius: 50px;
            font-size: .82rem; font-weight: 500;
        }
        .btn-logout {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.6);
            padding: .35rem .9rem; border-radius: 8px;
            font-size: .82rem; font-weight: 500;
            transition: all .2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.4); color: #fca5a5; }

        /* Cards */
        .card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; color: #fff;
        }
        .card-header {
            background: rgba(255,255,255,0.05) !important;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px 16px 0 0 !important;
        }
        .card-footer {
            background: rgba(255,255,255,0.03) !important;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; font-weight: 600;
        }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); transform: translateY(-1px); }
        .btn-outline-secondary {
            border-color: rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.6);
        }
        .btn-outline-secondary:hover { background: rgba(255,255,255,0.08); color: #fff; border-color: rgba(255,255,255,0.3); }
        .btn-success { background: linear-gradient(135deg, #22c55e, #16a34a); border: none; }
        .btn-outline-light { border-color: rgba(255,255,255,0.2); }
        .btn { border-radius: 8px; font-weight: 500; }

        /* Table */
        .table { color: rgba(255,255,255,0.8); }
        .table thead th { color: rgba(255,255,255,0.5); font-size: .78rem; text-transform: uppercase; letter-spacing: .06em; border-color: rgba(255,255,255,0.08); }
        .table td { border-color: rgba(255,255,255,0.06); vertical-align: middle; }
        .table-hover tbody tr:hover { background: rgba(255,255,255,0.04); }
        .table-light { background: rgba(255,255,255,0.05) !important; color: rgba(255,255,255,0.5); }

        /* Alerts */
        .alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; border-radius: 10px; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #86efac; border-radius: 10px; }
        .alert-info { background: rgba(6,182,212,0.1); border: 1px solid rgba(6,182,212,0.3); color: #67e8f9; border-radius: 10px; }

        /* Badge */
        .badge { border-radius: 6px; font-weight: 500; }
        .bg-success { background: rgba(34,197,94,0.2) !important; color: #4ade80 !important; }
        .bg-primary { background: rgba(99,102,241,0.2) !important; color: #a5b4fc !important; }
        .bg-secondary { background: rgba(255,255,255,0.1) !important; color: rgba(255,255,255,0.5) !important; }
        .bg-warning { background: rgba(245,158,11,0.2) !important; color: #fcd34d !important; }
        .bg-danger { background: rgba(239,68,68,0.2) !important; color: #fca5a5 !important; }

        /* Progress */
        .progress { background: rgba(255,255,255,0.08); }

        /* Form */
        .form-control, .form-select {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            color: #fff; border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.25); }
        .form-select option { background: #1e2a38; color: #fff; }
        .form-label { color: rgba(255,255,255,0.7); font-size: .88rem; font-weight: 500; }
        .form-text { color: rgba(255,255,255,0.35); font-size: .8rem; }

        /* Text */
        .text-muted { color: rgba(255,255,255,0.45) !important; }
        hr { border-color: rgba(255,255,255,0.08); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="voter-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('voter.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <div class="logo-icon"><i class="bi bi-shield-check text-white" style="font-size:.85rem;"></i></div>
                <span class="fw-bold text-white">VoteSecure</span>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('voter.dashboard') }}"
                   class="nav-link {{ request()->routeIs('voter.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house me-1"></i> Dashboard
                </a>
            </div>

            @auth
            <div class="d-flex align-items-center gap-2">
                <span class="user-badge">
                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>

    <!-- Footer -->
    <div class="text-center py-4 mt-5" style="border-top:1px solid rgba(255,255,255,0.06);color:rgba(255,255,255,0.2);font-size:.78rem;">
        © {{ date('Y') }} VoteSecure — Online Voting System
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
