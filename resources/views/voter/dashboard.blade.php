@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Welcome Banner -->
    <div class="p-4 mb-4 rounded-3 text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
        <div class="d-flex align-items-center gap-3">
            <div style="width:55px;height:55px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h4 class="fw-bold mb-0">Welcome, {{ auth()->user()->name }}!</h4>
                <p class="mb-0" style="color:rgba(255,255,255,0.6);font-size:.9rem;">Cast your vote in the active elections below.</p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i class="bi bi-calendar2-check me-2 text-primary"></i>Active Elections</h5>
        <span class="badge bg-primary rounded-pill">{{ $elections->count() }} election(s)</span>
    </div>

    <div class="row g-4">
        @forelse($elections as $election)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm" style="border-radius:14px; overflow:hidden;">
                    <div style="height:8px; background:linear-gradient(90deg,#6366f1,#06b6d4);"></div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0">{{ $election->title }}</h5>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <p class="text-muted small mb-3">{{ $election->description ?? 'No description provided.' }}</p>
                        <div class="d-flex flex-column gap-1 mb-3">
                            <small class="text-muted"><i class="bi bi-calendar-event me-2 text-primary"></i>Start: {{ $election->start_date->format('M d, Y H:i') }}</small>
                            <small class="text-muted"><i class="bi bi-calendar-x me-2 text-danger"></i>End: {{ $election->end_date->format('M d, Y H:i') }}</small>
                            <small class="text-muted"><i class="bi bi-people me-2 text-success"></i>{{ $election->candidates->count() }} candidate(s)</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-3 d-flex gap-2">
                        <a href="{{ route('voter.vote', $election->id) }}" class="btn btn-primary btn-sm flex-fill">
                            <i class="bi bi-check2-square me-1"></i> Vote Now
                        </a>
                        <a href="{{ route('voter.results', $election->id) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                            <i class="bi bi-bar-chart me-1"></i> Results
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-5 text-center shadow-sm">
                    <i class="bi bi-calendar-x text-muted" style="font-size:3rem;"></i>
                    <h5 class="mt-3 text-muted">No Active Elections</h5>
                    <p class="text-muted small">There are no active elections at the moment. Check back later.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
