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
    @stack('styles')

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { overflow-x: hidden; background: #0f172a; color: #fff; }

        /* ── Sidebar ── */
        #sidebar {
            width: 272px;
            min-height: 100vh;
            position: fixed; top: 0; left: 0; z-index: 200;
            display: flex; flex-direction: column;
            background: #070b14;
            border-right: 1px solid rgba(255,255,255,0.06);
            box-shadow: 4px 0 40px rgba(0,0,0,0.5);
        }

        /* Brand */
        .sb-brand {
            padding: 1.5rem 1.4rem 1.3rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; gap: .85rem;
        }
        .sb-brand-icon {
            width: 44px; height: 44px; flex-shrink: 0;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; color: #fff;
            box-shadow: 0 4px 16px rgba(245,158,11,0.35);
        }
        .sb-brand-text .sb-brand-name {
            font-size: .95rem; font-weight: 700; color: #fff; line-height: 1.2;
            letter-spacing: -.01em;
        }
        .sb-brand-text .sb-brand-role {
            font-size: .68rem; color: rgba(255,255,255,0.3);
            text-transform: uppercase; letter-spacing: .1em; margin-top: 1px;
        }

        /* Nav sections */
        .sb-section {
            padding: 1.4rem 1rem 0;
        }
        .sb-section-label {
            font-size: .65rem; font-weight: 700; color: rgba(255,255,255,0.2);
            text-transform: uppercase; letter-spacing: .14em;
            padding: 0 .5rem .6rem;
        }

        /* Nav items */
        .sb-nav-item { list-style: none; margin-bottom: 2px; }
        .sb-nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem .85rem;
            border-radius: 12px;
            color: rgba(255,255,255,0.45);
            font-size: .875rem; font-weight: 500;
            text-decoration: none;
            transition: all .2s cubic-bezier(.4,0,.2,1);
            position: relative;
            border: 1px solid transparent;
        }
        .sb-nav-link:hover {
            color: rgba(255,255,255,0.9);
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.07);
        }
        .sb-nav-link.active {
            color: #fff;
            background: rgba(99,102,241,0.15);
            border-color: rgba(99,102,241,0.3);
            box-shadow: 0 2px 12px rgba(99,102,241,0.15);
        }
        .sb-nav-link.active .sb-icon-wrap {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
            color: #fff;
        }
        .sb-nav-link .sb-active-dot {
            display: none;
            width: 6px; height: 6px;
            background: #6366f1;
            border-radius: 50%;
            margin-left: auto;
            box-shadow: 0 0 8px rgba(99,102,241,0.8);
        }
        .sb-nav-link.active .sb-active-dot { display: block; }

        /* Icon wrap */
        .sb-icon-wrap {
            width: 34px; height: 34px; flex-shrink: 0;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.06);
            font-size: .95rem;
            transition: all .2s;
        }
        .sb-nav-link:hover .sb-icon-wrap {
            background: rgba(255,255,255,0.1);
        }

        /* Divider */
        .sb-divider {
            height: 1px;
            background: rgba(255,255,255,0.05);
            margin: 1rem 1.4rem;
        }

        /* Footer */
        .sb-footer {
            margin-top: auto;
            padding: 1rem 1.4rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sb-user {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem .75rem;
            border-radius: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            margin-bottom: .75rem;
            transition: background .2s;
        }
        .sb-user:hover { background: rgba(255,255,255,0.07); }
        .sb-avatar {
            width: 36px; height: 36px; flex-shrink: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
            box-shadow: 0 2px 8px rgba(99,102,241,0.35);
        }
        .sb-user-name { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.2; }
        .sb-user-role { font-size: .7rem; color: rgba(255,255,255,0.3); margin-top: 1px; }
        .sb-logout {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; padding: .55rem;
            border-radius: 10px;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.18);
            color: rgba(239,68,68,0.7);
            font-size: .82rem; font-weight: 500;
            cursor: pointer; transition: all .2s;
        }
        .sb-logout:hover {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.35);
            color: #fca5a5;
        }

        /* Status pill */
        .sb-status {
            display: flex; align-items: center; gap: .5rem;
            padding: .45rem .75rem;
            border-radius: 8px;
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.18);
            margin-bottom: .75rem;
        }
        .sb-status-dot {
            width: 7px; height: 7px;
            background: #10b981; border-radius: 50%;
            animation: pulse-green 2s infinite;
            flex-shrink: 0;
        }
        @keyframes pulse-green {
            0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
            50%      { box-shadow: 0 0 0 4px rgba(16,185,129,0); }
        }
        .sb-status-text { font-size: .7rem; color: rgba(16,185,129,0.8); font-weight: 500; }

        /* ── Main Content ── */
        #main-content { margin-left: 272px; min-height: 100vh; }

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

    <!-- Brand -->
    <div class="sb-brand">
        <div class="sb-brand-icon"><i class="bi bi-shield-check"></i></div>
        <div class="sb-brand-text">
            <div class="sb-brand-name">VoteSecure</div>
            <div class="sb-brand-role">Admin Panel</div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="sb-section">
        <div class="sb-section-label">Main</div>
        <ul class="p-0 m-0">
            <li class="sb-nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sb-icon-wrap"><i class="bi bi-speedometer2"></i></span>
                    <span>Dashboard</span>
                    <span class="sb-active-dot"></span>
                </a>
            </li>
            <li class="sb-nav-item">
                <a href="{{ route('admin.elections.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                    <span class="sb-icon-wrap"><i class="bi bi-calendar2-check"></i></span>
                    <span>Elections</span>
                    <span class="sb-active-dot"></span>
                </a>
            </li>
            <li class="sb-nav-item">
                <a href="{{ route('admin.candidates.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.candidates.*') ? 'active' : '' }}">
                    <span class="sb-icon-wrap"><i class="bi bi-people-fill"></i></span>
                    <span>Candidates</span>
                    <span class="sb-active-dot"></span>
                </a>
            </li>
            <li class="sb-nav-item">
                <a href="{{ route('admin.voters.upload') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.voters.*') ? 'active' : '' }}">
                    <span class="sb-icon-wrap"><i class="bi bi-person-lines-fill"></i></span>
                    <span>Voters</span>
                    <span class="sb-active-dot"></span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sb-divider"></div>

    <!-- Settings / External -->
    <div style="padding: 0 1rem">
        <ul class="p-0 m-0">
            <li class="sb-nav-item">
                <a href="{{ route('home') }}" class="sb-nav-link" target="_blank">
                    <span class="sb-icon-wrap"><i class="bi bi-box-arrow-up-right"></i></span>
                    <span>View Site</span>
                </a>
            </li>
            <li class="sb-nav-item">
                <a href="{{ route('profile.edit') }}" class="sb-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="sb-icon-wrap"><i class="bi bi-gear"></i></span>
                    <span>Settings</span>
                    <span class="sb-active-dot"></span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="sb-footer">        <!-- User info -->
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="flex-1 min-width-0" style="overflow:hidden">
                <div class="sb-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->name }}</div>
                <div class="sb-user-role">Administrator</div>
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <i class="bi bi-box-arrow-right"></i>
                Sign Out
            </button>
        </form>
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
