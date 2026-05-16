@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Welcome Banner -->
    <div class="mb-5 p-5 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,#1e3a5f,#0f172a);">
        <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;background:rgba(99,102,241,0.12);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-40px;left:30%;width:150px;height:150px;background:rgba(6,182,212,0.08);border-radius:50%;"></div>
        <div class="d-flex align-items-center gap-4 position-relative">
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 8px 24px rgba(99,102,241,0.4);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p style="color:rgba(255,255,255,0.5);font-size:.82rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.2rem;">Welcome back</p>
                <h3 class="fw-bold text-white mb-1">{{ auth()->user()->name }}</h3>
                <p style="color:rgba(255,255,255,0.5);font-size:.9rem;margin:0;">Your voice matters — cast your vote in the elections below.</p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert d-flex align-items-center gap-3 mb-4 p-4" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" style="filter:invert(1)" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert d-flex align-items-center gap-3 mb-4 p-4" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);border-radius:12px;color:#86efac;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" style="filter:invert(1)" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Section Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold text-white mb-1"><i class="bi bi-calendar2-check me-2" style="color:#6366f1;"></i>Active Elections</h5>
            <p style="color:rgba(255,255,255,0.4);font-size:.85rem;margin:0;">Select an election to cast your vote</p>
        </div>
        <div style="background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;padding:.4rem 1rem;border-radius:50px;font-size:.82rem;font-weight:600;">
            {{ $elections->count() }} Active
        </div>
    </div>

    <div class="row g-4">
        @forelse($elections as $election)
            <div class="col-md-6 col-lg-4">
                <div class="h-100" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 40px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                    <!-- Top accent bar -->
                    <div style="height:4px;background:linear-gradient(90deg,#6366f1,#06b6d4,#22c55e);"></div>
                    <div class="p-4">
                        @php $progress = $voteProgress[$election->id] ?? ['voted'=>0,'total'=>0,'done'=>false]; @endphp
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div style="width:44px;height:44px;background:rgba(99,102,241,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-calendar2-check" style="color:#a5b4fc;font-size:1.1rem;"></i>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                @if($progress['done'])
                                    <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Voted
                                    </span>
                                @else
                                    <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.4rem;vertical-align:middle;"></i>LIVE
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h5 class="fw-bold text-white mb-2">{{ $election->title }}</h5>
                        <p style="color:rgba(255,255,255,0.45);font-size:.85rem;line-height:1.5;margin-bottom:1.2rem;">{{ $election->description ?? 'Participate in this election and make your voice heard.' }}</p>

                        <!-- Voting progress -->
                        @if($progress['total'] > 0)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small style="color:rgba(255,255,255,0.4);font-size:.78rem;">Voting Progress</small>
                                    <small style="color:rgba(255,255,255,0.6);font-size:.78rem;font-weight:600;">{{ $progress['voted'] }}/{{ $progress['total'] }} positions</small>
                                </div>
                                <div style="height:5px;background:rgba(255,255,255,0.08);border-radius:99px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $progress['total'] > 0 ? round(($progress['voted']/$progress['total'])*100) : 0 }}%;background:{{ $progress['done'] ? 'linear-gradient(90deg,#22c55e,#16a34a)' : 'linear-gradient(90deg,#6366f1,#06b6d4)' }};border-radius:99px;transition:width .4s;"></div>
                                </div>
                            </div>
                        @endif

                        <div style="background:rgba(255,255,255,0.04);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.2rem;">
                            <div class="d-flex justify-content-between mb-2">
                                <small style="color:rgba(255,255,255,0.4);"><i class="bi bi-calendar-event me-1" style="color:#6366f1;"></i>Starts</small>
                                <small style="color:rgba(255,255,255,0.7);font-weight:500;">{{ $election->start_date->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small style="color:rgba(255,255,255,0.4);"><i class="bi bi-calendar-x me-1" style="color:#ef4444;"></i>Ends</small>
                                <small style="color:rgba(255,255,255,0.7);font-weight:500;">{{ $election->end_date->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small style="color:rgba(255,255,255,0.4);"><i class="bi bi-people me-1" style="color:#22c55e;"></i>Candidates</small>
                                <small style="color:rgba(255,255,255,0.7);font-weight:500;">{{ $election->candidates->count() }}</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('voter.verify', $election->id) }}"
                               style="flex:1;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:10px;padding:.6rem 1rem;font-size:.88rem;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:opacity .2s;"
                               onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                <i class="bi bi-check2-square"></i> Vote Now
                            </a>
                            <a href="{{ route('voter.results', $election->id) }}"
                               style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:.6rem 1rem;font-size:.88rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:.4rem;transition:all .2s;"
                               onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                                <i class="bi bi-bar-chart"></i> Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:20px;">
                    <div style="width:80px;height:80px;background:rgba(255,255,255,0.05);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                        <i class="bi bi-calendar-x" style="font-size:2rem;color:rgba(255,255,255,0.2);"></i>
                    </div>
                    <h5 style="color:rgba(255,255,255,0.4);">No Active Elections</h5>
                    <p style="color:rgba(255,255,255,0.25);font-size:.88rem;">There are no active elections at the moment. Check back later.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
