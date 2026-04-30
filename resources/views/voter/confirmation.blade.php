@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
                    <h2 class="fw-bold mt-3">Thank you for voting!</h2>
                    <p class="text-muted">Your vote has been recorded successfully.</p>

                    <hr>

                    <ul class="list-unstyled text-start mt-3">
                        <li class="mb-2">
                            <strong>Election:</strong> {{ session('election_title') }}
                        </li>
                        <li class="mb-2">
                            <strong>Candidate:</strong> {{ session('candidate_name') }}
                        </li>
                        <li class="mb-2">
                            <strong>Voted At:</strong> {{ session('voted_at') }}
                        </li>
                    </ul>

                    <div class="mt-4 d-flex justify-content-center gap-2">
                        <a href="{{ route('voter.results', session('election_id')) }}" class="btn btn-primary">View Results</a>
                        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
