@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="p-4 mb-4 rounded-3 text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-sm btn-outline-light mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Elections
        </a>
        <h4 class="fw-bold mb-1">{{ $election->title }}</h4>
        <p class="mb-0" style="color:rgba(255,255,255,0.6);font-size:.9rem;">{{ $election->description ?? 'Cast your vote for each position below.' }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($election->positions as $position)
        @php $alreadyVotedHere = in_array($position->id, $votedPositionIds); @endphp

        <div class="mb-5">
            <div class="d-flex align-items-center gap-3 mb-3">
                <h5 class="fw-bold mb-0">
                    <span class="badge me-2" style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);font-size:.95rem;">
                        {{ $position->name }}
                    </span>
                </h5>
                @if($alreadyVotedHere)
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Voted</span>
                @endif
            </div>

            @if($alreadyVotedHere)
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    You have already cast your vote for <strong>{{ $position->name }}</strong>.
                </div>
            @else
                <form action="{{ route('voter.cast') }}" method="POST">
                    @csrf
                    <input type="hidden" name="election_id" value="{{ $election->id }}">
                    <input type="hidden" name="position_id" value="{{ $position->id }}">

                    <div class="row g-3 mb-3">
                        @forelse($position->candidates as $candidate)
                            <div class="col-md-4">
                                <label class="w-100 h-100" style="cursor:pointer;">
                                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}"
                                           class="d-none candidate-radio" required>
                                    <div class="card h-100 shadow-sm candidate-card text-center p-4"
                                         style="border:2px solid #e5e7eb; border-radius:14px; transition:all .2s;">
                                        @if($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                 class="rounded-circle mx-auto mb-3"
                                                 width="90" height="90" style="object-fit:cover; border:3px solid #e5e7eb;">
                                        @else
                                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                                 style="width:90px;height:90px;background:#e5e7eb;">
                                                <i class="bi bi-person-fill text-secondary" style="font-size:2rem;"></i>
                                            </div>
                                        @endif
                                        <h6 class="fw-bold mb-1">{{ $candidate->name }}</h6>
                                        <p class="text-muted small mb-3">{{ $candidate->bio ?? 'No biography provided.' }}</p>
                                        <div class="select-indicator mt-auto py-2 px-3 rounded-pill"
                                             style="background:#f3f4f6; font-size:.82rem; font-weight:600; color:#6b7280;">
                                            <i class="bi bi-circle me-1"></i> Click to Select
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">No candidates added for this position yet.</div>
                            </div>
                        @endforelse

                        @if($position->candidates->count())
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-2"
                                        onclick="return confirm('Submit your vote for {{ $position->name }}? This cannot be undone.')">
                                    <i class="bi bi-check2-square me-1"></i> Vote for {{ $position->name }}
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            @endif
        </div>

        @if(!$loop->last)<hr style="border-color:rgba(0,0,0,0.1);">@endif

    @empty
        <div class="alert alert-info">No positions have been set up for this election yet.</div>
    @endforelse

</div>

<style>
    .candidate-radio:checked + .candidate-card {
        border-color: #6366f1 !important;
        background: #f5f3ff;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.15) !important;
    }
    .candidate-radio:checked + .candidate-card .select-indicator {
        background: #6366f1; color: #fff;
    }
    .candidate-card:hover { border-color: #6366f1 !important; transform: translateY(-3px); }
</style>
@endsection
