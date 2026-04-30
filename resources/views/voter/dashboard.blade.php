@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Active Elections</h3>
        <span class="text-muted">Welcome, {{ auth()->user()->name }}</span>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($elections as $election)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $election->title }}</h5>
                            @if($election->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($election->status == 'upcoming')
                                <span class="badge bg-secondary">Upcoming</span>
                            @else
                                <span class="badge bg-danger">Closed</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-3">{{ $election->description }}</p>
                        <ul class="list-unstyled small text-muted mb-3">
                            <li><i class="bi bi-calendar-event me-1"></i> Start: {{ $election->start_date->format('Y-m-d H:i') }}</li>
                            <li><i class="bi bi-calendar-x me-1"></i> End: {{ $election->end_date->format('Y-m-d H:i') }}</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex gap-2">
                        <a href="{{ route('voter.vote', $election->id) }}" class="btn btn-primary btn-sm w-50">
                            <i class="bi bi-check2-square me-1"></i> Vote Now
                        </a>
                        <a href="{{ route('voter.results', $election->id) }}" class="btn btn-outline-secondary btn-sm w-50">
                            <i class="bi bi-bar-chart me-1"></i> Results
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No active elections at the moment.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
