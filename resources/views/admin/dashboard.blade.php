@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-icon', 'speedometer2')
@section('page-subtitle', 'Overview of the Online Voting System.')

@section('content')

{{-- Hero Welcome --}}
<div class="mb-5 p-5 rounded-4 position-relative overflow-hidden"
     style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
    <div style="position:absolute;top:-80px;right:-80px;width:320px;height:320px;background:radial-gradient(circle,rgba(99,102,241,0.12),transparent 70%);border-radius:50%;pointer-events:none;"></div>
    <div style="position:absolute;bottom:-60px;left:20%;width:220px;height:220px;background:radial-gradient(circle,rgba(6,182,212,0.07),transparent 70%);border-radius:50%;pointer-events:none;"></div>
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-4">
        <div>
            <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.5rem;">
                <i class="bi bi-shield-check me-2" style="color:#6366f1;"></i>VoteSecure Admin
            </p>
            <h2 class="fw-bold text-white mb-2" style="font-size:1.6rem;">Welcome back, {{ auth()->user()->name }} 👋</h2>
            <p style="color:rgba(255,255,255,0.4);font-size:.9rem;margin:0;">Here's what's happening with your elections today.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.elections.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Election
            </a>
            <a href="{{ route('admin.candidates.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-person-plus me-1"></i>Add Candidate
            </a>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="row g-4 mb-5">

    {{-- Elections --}}
    <div class="col-sm-6 col-xl-3">
        <div class="h-100 p-4 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(99,102,241,0.05));border:1px solid rgba(99,102,241,0.25);">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(99,102,241,0.1);border-radius:50%;"></div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div style="width:48px;height:48px;background:rgba(99,102,241,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-calendar2-check" style="color:#a5b4fc;font-size:1.3rem;"></i>
                </div>
                <a href="{{ route('admin.elections.index') }}" style="color:rgba(99,102,241,0.7);font-size:.78rem;text-decoration:none;font-weight:600;letter-spacing:.05em;">VIEW ALL →</a>
            </div>
            <div style="font-size:2.8rem;font-weight:800;color:#fff;line-height:1;margin-bottom:.3rem;">{{ $elections }}</div>
            <div style="color:rgba(255,255,255,0.5);font-size:.88rem;font-weight:500;">Total Elections</div>
            <div class="mt-3" style="height:3px;background:rgba(255,255,255,0.06);border-radius:2px;">
                <div style="height:3px;background:linear-gradient(90deg,#6366f1,#8b5cf6);border-radius:2px;width:{{ $elections > 0 ? min(100, $elections * 10) : 5 }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Candidates --}}
    <div class="col-sm-6 col-xl-3">
        <div class="h-100 p-4 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,rgba(34,197,94,0.15),rgba(34,197,94,0.05));border:1px solid rgba(34,197,94,0.25);">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(34,197,94,0.1);border-radius:50%;"></div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div style="width:48px;height:48px;background:rgba(34,197,94,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-people-fill" style="color:#4ade80;font-size:1.3rem;"></i>
                </div>
                <a href="{{ route('admin.candidates.index') }}" style="color:rgba(34,197,94,0.7);font-size:.78rem;text-decoration:none;font-weight:600;letter-spacing:.05em;">VIEW ALL →</a>
            </div>
            <div style="font-size:2.8rem;font-weight:800;color:#fff;line-height:1;margin-bottom:.3rem;">{{ $candidates }}</div>
            <div style="color:rgba(255,255,255,0.5);font-size:.88rem;font-weight:500;">Total Candidates</div>
            <div class="mt-3" style="height:3px;background:rgba(255,255,255,0.06);border-radius:2px;">
                <div style="height:3px;background:linear-gradient(90deg,#22c55e,#16a34a);border-radius:2px;width:{{ $candidates > 0 ? min(100, $candidates * 5) : 5 }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Voters --}}
    <div class="col-sm-6 col-xl-3">
        <div class="h-100 p-4 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05));border:1px solid rgba(245,158,11,0.25);">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(245,158,11,0.1);border-radius:50%;"></div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div style="width:48px;height:48px;background:rgba(245,158,11,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-check-fill" style="color:#fcd34d;font-size:1.3rem;"></i>
                </div>
                <span style="color:rgba(245,158,11,0.7);font-size:.78rem;font-weight:600;letter-spacing:.05em;">REGISTERED</span>
            </div>
            <div style="font-size:2.8rem;font-weight:800;color:#fff;line-height:1;margin-bottom:.3rem;">{{ $voters }}</div>
            <div style="color:rgba(255,255,255,0.5);font-size:.88rem;font-weight:500;">Registered Voters</div>
            <div class="mt-3" style="height:3px;background:rgba(255,255,255,0.06);border-radius:2px;">
                <div style="height:3px;background:linear-gradient(90deg,#f59e0b,#d97706);border-radius:2px;width:{{ $voters > 0 ? min(100, $voters * 2) : 5 }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Votes --}}
    <div class="col-sm-6 col-xl-3">
        <div class="h-100 p-4 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,rgba(239,68,68,0.15),rgba(239,68,68,0.05));border:1px solid rgba(239,68,68,0.25);">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(239,68,68,0.1);border-radius:50%;"></div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div style="width:48px;height:48px;background:rgba(239,68,68,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-check2-square" style="color:#fca5a5;font-size:1.3rem;"></i>
                </div>
                <span style="color:rgba(239,68,68,0.7);font-size:.78rem;font-weight:600;letter-spacing:.05em;">CAST</span>
            </div>
            <div style="font-size:2.8rem;font-weight:800;color:#fff;line-height:1;margin-bottom:.3rem;">{{ $votes }}</div>
            <div style="color:rgba(255,255,255,0.5);font-size:.88rem;font-weight:500;">Votes Cast</div>
            <div class="mt-3" style="height:3px;background:rgba(255,255,255,0.06);border-radius:2px;">
                <div style="height:3px;background:linear-gradient(90deg,#ef4444,#dc2626);border-radius:2px;width:{{ $votes > 0 ? min(100, $votes * 2) : 5 }}%;"></div>
            </div>
        </div>
    </div>

</div>

{{-- Quick Actions --}}
<div class="mb-4">
    <h6 style="color:rgba(255,255,255,0.4);font-size:.75rem;text-transform:uppercase;letter-spacing:.12em;margin-bottom:1rem;">
        <i class="bi bi-lightning-charge-fill me-2" style="color:#f59e0b;"></i>Quick Actions
    </h6>
    <div class="row g-3">
        @foreach([
            [route('admin.elections.create'),  'bi-plus-circle-fill',  '99,102,241', '#a5b4fc', 'New Election',   'Create election'],
            [route('admin.candidates.create'), 'bi-person-plus-fill',  '34,197,94',  '#4ade80', 'Add Candidate',  'Register candidate'],
            [route('admin.voters.upload'),     'bi-upload',            '245,158,11', '#fcd34d', 'Upload Voters',  'Import voter list'],
            [route('admin.elections.index'),   'bi-bar-chart-fill',    '6,182,212',  '#67e8f9', 'View Elections', 'Manage all elections'],
        ] as [$href, $icon, $rgb, $iconColor, $title, $sub])
        <div class="col-md-3 col-sm-6">
            <a href="{{ $href }}" class="qa-card d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
               style="background:rgba({{ $rgb }},0.08);border:1px solid rgba({{ $rgb }},0.2);--qa-hover:rgba({{ $rgb }},0.16);">
                <div style="width:40px;height:40px;background:rgba({{ $rgb }},0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi {{ $icon }}" style="color:{{ $iconColor }};"></i>
                </div>
                <div>
                    <div style="color:#fff;font-weight:600;font-size:.88rem;">{{ $title }}</div>
                    <div style="color:rgba(255,255,255,0.35);font-size:.75rem;">{{ $sub }}</div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
.qa-card { transition: background .2s, transform .2s; }
.qa-card:hover { background: var(--qa-hover) !important; transform: translateY(-2px); }
</style>
@endpush

{{-- Recent Elections Table --}}
<div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.12em;margin:0;">
            <i class="bi bi-clock-history me-2" style="color:#6366f1;"></i>Recent Elections
        </h6>
        <a href="{{ route('admin.elections.index') }}" style="color:#a5b4fc;font-size:.8rem;text-decoration:none;font-weight:600;">View All →</a>
    </div>
    <div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.03);--bs-table-color:rgba(255,255,255,0.8);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead style="background:rgba(255,255,255,0.04);">
                <tr>
                    <th style="padding:1rem 1.2rem;color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Election</th>
                    <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Status</th>
                    <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Period</th>
                    <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;text-align:right;padding-right:1.2rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentElections as $election)
                <tr>
                    <td style="padding:1rem 1.2rem;">
                        <div style="font-weight:600;color:#fff;">{{ $election->title }}</div>
                        <div style="color:rgba(255,255,255,0.35);font-size:.78rem;">{{ $election->candidates_count }} candidate(s)</div>
                    </td>
                    <td>
                        @if($election->status === 'active')
                            <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                <span style="width:6px;height:6px;background:#4ade80;border-radius:50%;display:inline-block;"></span>Active
                            </span>
                        @elseif($election->status === 'upcoming')
                            <span style="background:rgba(245,158,11,0.15);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                                <i class="bi bi-clock me-1"></i>Upcoming
                            </span>
                        @else
                            <span style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.35);border:1px solid rgba(255,255,255,0.1);padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                                <i class="bi bi-lock me-1"></i>Closed
                            </span>
                        @endif
                    </td>
                    <td style="color:rgba(255,255,255,0.45);font-size:.82rem;">
                        {{ $election->start_date->format('M d') }} — {{ $election->end_date->format('M d, Y') }}
                    </td>
                    <td style="text-align:right;padding-right:1.2rem;">
                        <a href="{{ route('admin.elections.edit', $election) }}" style="color:#a5b4fc;font-size:.82rem;text-decoration:none;font-weight:500;margin-right:.8rem;">Edit</a>
                        <a href="{{ route('admin.elections.show', $election) }}" style="color:rgba(255,255,255,0.35);font-size:.82rem;text-decoration:none;font-weight:500;">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:3rem;color:rgba(255,255,255,0.2);">
                        <i class="bi bi-calendar-x d-block mb-2" style="font-size:2rem;"></i>
                        No elections yet. <a href="{{ route('admin.elections.create') }}" style="color:#a5b4fc;">Create one →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
