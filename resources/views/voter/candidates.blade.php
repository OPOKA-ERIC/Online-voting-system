@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="p-4 mb-4 rounded-3 text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-sm btn-outline-light mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Elections
        </a>
        <h4 class="fw-bold mb-1">{{ $election->title }}</h4>
        <p class="mb-0" style="color:rgba(255,255,255,0.6);font-size:.9rem;">{{ $election->description ?? 'Select a candidate to cast your vote.' }}</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($hasVoted)
        <div class="card shadow-sm p-4 text-center mb-4" style="border-left: 5px solid #22c55e;">
            <i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i>
            <h5 class="fw-bold mt-3">You have already voted in this election.</h5>
            <p class="text-muted">Your vote has been recorded. You can view the current results below.</p>
            <a href="{{ route('voter.results', $election->id) }}" class="btn btn-success mt-2">
                <i class="bi bi-bar-chart me-1"></i> View Results
            </a>
        </div>
    @else
        <h5 class="fw-bold mb-3"><i class="bi bi-people me-2 text-primary"></i>Select a Candidate</h5>

        <form action="{{ route('voter.cast') }}" method="POST" id="voteForm">
            @csrf
            <input type="hidden" name="election_id" value="{{ $election->id }}">

            <div class="row g-4 mb-4">
                @forelse($candidates as $candidate)
                    <div class="col-md-4">
                        <label class="w-100 h-100" style="cursor:pointer;">
                            <input type="radio" name="candidate_id" value="{{ $candidate->id }}"
                                   class="d-none candidate-radio" required>
                            <div class="card h-100 shadow-sm candidate-card text-center p-4"
                                 style="border:2px solid #e5e7eb; border-radius:14px; transition: all .2s;">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}"
                                         class="rounded-circle mx-auto mb-3"
                                         width="100" height="100" style="object-fit:cover; border:3px solid #e5e7eb;">
                                @else
                                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                         style="width:100px;height:100px;background:#e5e7eb;">
                                        <i class="bi bi-person-fill text-secondary" style="font-size:2.5rem;"></i>
                                    </div>
                                @endif
                                <h5 class="fw-bold mb-1">{{ $candidate->name }}</h5>
                                <p class="text-muted small mb-3">{{ $candidate->bio ?? 'No biography provided.' }}</p>
                                <div class="select-indicator mt-auto py-2 px-3 rounded-pill"
                                     style="background:#f3f4f6; font-size:.85rem; font-weight:600; color:#6b7280;">
                                    <i class="bi bi-circle me-1"></i> Click to Select
                                </div>
                            </div>
                        </label>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No candidates available for this election.</div>
                    </div>
                @endforelse
            </div>

            @if($candidates->count())
                <div class="card shadow-sm p-4 d-flex flex-row justify-content-between align-items-center">
                    <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i> Your vote is final and cannot be changed.</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"
                                onclick="return confirm('Are you sure? This vote cannot be undone.')">
                            <i class="bi bi-check2-square me-1"></i> Submit Vote
                        </button>
                    </div>
                </div>
            @endif
        </form>
    @endif
</div>

<style>
    .candidate-radio:checked + .candidate-card {
        border-color: #6366f1 !important;
        background: #f5f3ff;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.15) !important;
    }
    .candidate-radio:checked + .candidate-card .select-indicator {
        background: #6366f1;
        color: #fff;
    }
    .candidate-radio:checked + .candidate-card .select-indicator i::before {
        content: "\f26a";
    }
    .candidate-card:hover {
        border-color: #6366f1 !important;
        transform: translateY(-3px);
    }
</style>
@endsection
