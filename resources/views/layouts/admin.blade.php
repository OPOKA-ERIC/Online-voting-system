<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — {{ config('app.name', 'Online Voting System') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { overflow-x: hidden; background: #0f172a; color: #fff; }

        /* ── Sidebar ── */
        #sidebar {
            min-height: 100vh; width: 260px;
            background: linear-gradient(180deg, #080e1a 0%, #0f172a 100%);
            position: fixed; top: 0; left: 0; z-index: 200;
            box-shadow: 4px 0 20px rgba(0,0,0,0.4);
            display: flex; flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand { padding: 1.5rem 1.5rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-brand .brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #fff; margin-bottom: .6rem;
        }
        .sidebar-brand .brand-title { font-size: 1rem; font-weight: 700; color: #fff; line-height: 1.2; }
        .sidebar-brand .brand-sub { font-size: .72rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: .08em; }
        .sidebar-section-label {
            font-size: .68rem; font-weight: 600; color: rgba(255,255,255,0.25);
            text-transform: uppercase; letter-spacing: .1em; padding: 1.2rem 1.5rem .4rem;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,0.55); padding: .7rem 1.5rem;
            font-size: .88rem; font-weight: 500; border-radius: 0;
            display: flex; align-items: center; gap: .65rem;
            transition: all .2s; border-left: 3px solid transparent;
        }
        #sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.06); border-left-color: rgba(255,255,255,0.2); }
        #sidebar .nav-link.active { color: #fff; background: rgba(245,158,11,0.12); border-left-color: #f59e0b; }
        #sidebar .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-footer { margin-top: auto; padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.07); }
        .admin-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
        }

        /* ── Main Content ── */
        #main-content { margin-left: 260px; min-height: 100vh; }

        /* ── Top Navbar ── */
        #topnav {
            background: rgba(8,14,26,0.98);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: .75rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            backdrop-filter: blur(10px);
        }
        .topnav-breadcrumb { font-size: .82rem; color: rgba(255,255,255,0.35); }
        .topnav-breadcrumb span { color: #fff; font-weight: 600; }
        .topnav-right { display: flex; align-items: center; gap: 1rem; }
        .topnav-badge {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
        }

        /* ── Page Header Banner ── */
        .page-header-banner {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            color: #fff; padding: 2rem 2rem 1.8rem;
        }
        .page-header-banner h4 { font-weight: 700; margin-bottom: .2rem; }
        .page-header-banner p { color: rgba(255,255,255,0.45); font-size: .85rem; margin: 0; }

        /* ── Content Area ── */
        .content-area { padding: 1.75rem; background: #0f172a; min-height: calc(100vh - 130px); }

        /* ── Cards ── */
        .card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: #fff; }
        .card-header { border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem; font-weight: 600; font-size: .95rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .card-footer { background: rgba(255,255,255,0.03) !important; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── Forms ── */
        .form-label { font-weight: 500; font-size: .88rem; color: rgba(255,255,255,0.7); margin-bottom: .4rem; }
        .form-control, .form-select {
            background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.1);
            color: #fff; border-radius: 8px; font-size: .9rem; padding: .55rem .85rem;
            transition: all .2s;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08); border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2); color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.25); }
        .form-select option { background: #1e2a38; color: #fff; }
        .form-text { color: rgba(255,255,255,0.35); font-size: .8rem; }
        textarea.form-control { resize: vertical; }

        /* ── Buttons ── */
        .btn { border-radius: 8px; font-weight: 500; font-size: .88rem; padding: .5rem 1.2rem; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; color: #fff; }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); color: #fff; transform: translateY(-1px); }
        .btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: #fff; }
        .btn-warning:hover { background: linear-gradient(135deg, #d97706, #b45309); color: #fff; }
        .btn-secondary { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.7); }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .btn-outline-primary { border-color: rgba(99,102,241,0.5); color: #a5b4fc; }
        .btn-outline-primary:hover { background: rgba(99,102,241,0.15); color: #fff; border-color: #6366f1; }
        .btn-outline-danger { border-color: rgba(239,68,68,0.4); color: #fca5a5; }
        .btn-outline-danger:hover { background: rgba(239,68,68,0.12); color: #fca5a5; }
        .btn-outline-secondary { border-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.6); }
        .btn-outline-secondary:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .btn-outline-light { border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.7); }
        .btn-outline-light:hover { background: rgba(255,255,255,0.08); color: #fff; }

        /* ── Tables ── */
        .table { color: rgba(255,255,255,0.8); }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .06em; font-weight: 600; color: rgba(255,255,255,0.4); border-color: rgba(255,255,255,0.08); }
        .table td { border-color: rgba(255,255,255,0.06); vertical-align: middle; }
        .table-dark { background: rgba(255,255,255,0.06) !important; color: rgba(255,255,255,0.6) !important; }
        .table-light { background: rgba(255,255,255,0.04) !important; color: rgba(255,255,255,0.5) !important; }
        .table-hover tbody tr:hover { background: rgba(255,255,255,0.04); }

        /* ── Badges ── */
        .badge { border-radius: 6px; font-weight: 500; font-size: .75rem; padding: .35em .65em; }
        .bg-success { background: rgba(34,197,94,0.2) !important; color: #4ade80 !important; }
        .bg-primary { background: rgba(99,102,241,0.2) !important; color: #a5b4fc !important; }
        .bg-secondary { background: rgba(255,255,255,0.1) !important; color: rgba(255,255,255,0.5) !important; }
        .bg-warning { background: rgba(245,158,11,0.2) !important; color: #fcd34d !important; }
        .bg-danger { background: rgba(239,68,68,0.2) !important; color: #fca5a5 !important; }
        .bg-dark { background: rgba(255,255,255,0.06) !important; }

        /* ── Alerts ── */
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #86efac; border-radius: 10px; }
        .alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; border-radius: 10px; }
        .alert-info { background: rgba(6,182,212,0.1); border: 1px solid rgba(6,182,212,0.3); color: #67e8f9; border-radius: 10px; }
        .btn-close { filter: invert(1); }

        /* ── Misc ── */
        .text-muted { color: rgba(255,255,255,0.4) !important; }
        hr { border-color: rgba(255,255,255,0.08); }
        .progress { background: rgba(255,255,255,0.08); }

        /* ── Photo Preview ── */
        #photo-preview-wrap {
            border: 2px dashed rgba(255,255,255,0.15); border-radius: 12px;
            padding: 2rem; text-align: center; background: rgba(255,255,255,0.03);
            cursor: pointer; transition: border-color .2s;
        }
        #photo-preview-wrap:hover { border-color: #6366f1; }
        #photo-preview-wrap img { max-height: 160px; border-radius: 8px; display: none; }
        #photo-preview-wrap .upload-placeholder i { font-size: 2.5rem; color: rgba(255,255,255,0.25); }
        #photo-preview-wrap .upload-placeholder p { color: rgba(255,255,255,0.35); font-size: .85rem; margin: .5rem 0 0; }
    </style>
</head>
<body>

<!-- ══════════════ SIDEBAR ══════════════ -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="bi bi-shield-check"></i></div>
        <div class="brand-title">Online Voting</div>
        <div class="brand-sub">Admin Panel</div>
    </div>

    <div class="sidebar-section-label">Main Menu</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.elections.index') }}"
               class="nav-link {{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check"></i> Elections
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.candidates.index') }}"
               class="nav-link {{ request()->routeIs('admin.candidates.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Candidates
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div style="font-size:.82rem; font-weight:600; color:#fff;">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem; color:rgba(255,255,255,0.35);">Administrator</div>
            </div>
        </div>
    </div>
</nav>

<!-- ══════════════ MAIN CONTENT ══════════════ -->
<div id="main-content">

    <!-- Top Navbar -->
    <div id="topnav">
        <div class="topnav-breadcrumb">
            Admin Panel &rsaquo; <span>@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topnav-right">
            <div class="d-flex align-items-center gap-2">
                <div class="topnav-badge">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div style="font-size:.85rem; font-weight:600; color:#fff;">{{ auth()->user()->name }}</div>
                    <div style="font-size:.75rem; color:rgba(255,255,255,0.35);">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Page Header Banner -->
    <div class="page-header-banner">
        <h4><i class="bi bi-@yield('page-icon', 'house') me-2"></i>@yield('page-title', 'Dashboard')</h4>
        <p>@yield('page-subtitle', 'Welcome to the Online Voting System admin panel.')</p>
    </div>

    <!-- Page Content -->
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
