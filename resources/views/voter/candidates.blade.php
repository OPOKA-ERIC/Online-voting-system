@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold mb-0">{{ $election->title }}</h3>
            <span class="badge bg-success">Active</span>
        </div>
        <p class="text-muted mt-1">{{ $election->description }}</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($hasVoted)
        <div class="alert alert-success d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            You have already voted in this election.
            <a href="{{ route('voter.results', $election->id) }}" class="ms-auto btn btn-sm btn-success">View Results</a>
        </div>
    @else
        <form action="{{ route('voter.cast') }}" method="POST">
            @csrf
            <input type="hidden" name="election_id" value="{{ $election->id }}">

            <div class="row g-4">
                @forelse($candidates as $candidate)
                    <div class="col-md-4">
                        <label class="card shadow-sm h-100 cursor-pointer w-100" style="cursor:pointer;">
                            <div class="card-body text-center">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}"
                                         class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3"
                                         style="width:90px;height:90px;">
                                        <i class="bi bi-person-fill text-white" style="font-size:2.5rem;"></i>
                                    </div>
                                @endif
                                <h5 class="fw-bold">{{ $candidate->name }}</h5>
                                <p class="text-muted small">{{ $candidate->bio }}</p>
                                <div class="form-check d-flex justify-content-center mt-2">
                                    <input class="form-check-input me-2" type="radio"
                                           name="candidate_id" value="{{ $candidate->id }}" required>
                                    <label class="form-check-label fw-semibold">Select</label>
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
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Confirm your vote? This cannot be undone.')">
                        <i class="bi bi-check2-square me-1"></i> Submit Vote
                    </button>
                    <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            @endif
        </form>
    @endif
</div>
@endsection
