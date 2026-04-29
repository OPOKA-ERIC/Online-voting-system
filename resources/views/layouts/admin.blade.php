<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — {{ config('app.name', 'Online Voting System') }}</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { overflow-x: hidden; background-color: #f0f2f5; }

        /* ── Sidebar ── */
        #sidebar {
            min-height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #1e3a5f 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            box-shadow: 4px 0 15px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #fff; font-weight: 700;
            margin-bottom: .6rem;
        }
        .sidebar-brand .brand-title {
            font-size: 1rem; font-weight: 700; color: #fff; line-height: 1.2;
        }
        .sidebar-brand .brand-sub {
            font-size: .72rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: .08em;
        }
        .sidebar-section-label {
            font-size: .68rem; font-weight: 600; color: rgba(255,255,255,0.3);
            text-transform: uppercase; letter-spacing: .1em;
            padding: 1.2rem 1.5rem .4rem;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,0.6);
            padding: .7rem 1.5rem;
            font-size: .88rem;
            font-weight: 500;
            border-radius: 0;
            display: flex; align-items: center; gap: .65rem;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        #sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.07);
            border-left-color: rgba(255,255,255,0.3);
        }
        #sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(245,158,11,0.15);
            border-left-color: #f59e0b;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer .admin-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
        }

        /* ── Main Content ── */
        #main-content { margin-left: 260px; min-height: 100vh; }

        /* ── Top Navbar ── */
        #topnav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }
        .topnav-breadcrumb { font-size: .82rem; color: #6b7280; }
        .topnav-breadcrumb span { color: #111827; font-weight: 600; }
        .topnav-right { display: flex; align-items: center; gap: 1rem; }
        .topnav-badge {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
        }

        /* ── Page Header Banner ── */
        .page-header-banner {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
            color: #fff;
            padding: 2rem 2rem 1.8rem;
            margin-bottom: 0;
        }
        .page-header-banner h4 { font-weight: 700; margin-bottom: .2rem; }
        .page-header-banner p { color: rgba(255,255,255,0.55); font-size: .85rem; margin: 0; }

        /* ── Cards & Content ── */
        .content-area { padding: 1.75rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: .95rem;
        }
        .form-label { font-weight: 500; font-size: .88rem; color: #374151; margin-bottom: .4rem; }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            font-size: .9rem;
            padding: .55rem .85rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .btn { border-radius: 8px; font-weight: 500; font-size: .88rem; padding: .5rem 1.2rem; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); }
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; font-weight: 600; }
        .badge { border-radius: 6px; font-weight: 500; font-size: .75rem; padding: .35em .65em; }

        /* ── Photo Preview ── */
        #photo-preview-wrap {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: border-color .2s;
        }
        #photo-preview-wrap:hover { border-color: #6366f1; }
        #photo-preview-wrap img { max-height: 160px; border-radius: 8px; display: none; }
        #photo-preview-wrap .upload-placeholder i { font-size: 2.5rem; color: #9ca3af; }
        #photo-preview-wrap .upload-placeholder p { color: #6b7280; font-size: .85rem; margin: .5rem 0 0; }
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
                <div style="font-size:.72rem; color:rgba(255,255,255,0.4);">Administrator</div>
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
                    <div style="font-size:.85rem; font-weight:600; color:#111827;">{{ auth()->user()->name }}</div>
                    <div style="font-size:.75rem; color:#6b7280;">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
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
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
