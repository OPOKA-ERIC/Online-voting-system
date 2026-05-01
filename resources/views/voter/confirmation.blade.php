@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow text-center" style="border-radius:16px; overflow:hidden;">
                <div style="height:8px; background:linear-gradient(90deg,#22c55e,#06b6d4);"></div>
                <div class="card-body p-5">
                    <div class="mb-3" style="width:80px;height:80px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        <i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i>
                    </div>
                    <h3 class="fw-bold mt-3">Vote Submitted!</h3>
                    <p class="text-muted">Your vote has been recorded successfully.</p>

                    <div class="card mt-4 text-start" style="background:#f8fafc; border-radius:10px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:38px;height:38px;background:#e0e7ff;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-calendar2-check text-primary"></i>
                                </div>
                                <div>
                                    <div style="font-size:.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Election</div>
                                    <div class="fw-semibold">{{ session('election_title', 'N/A') }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:38px;height:38px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-person-check text-success"></i>
                                </div>
                                <div>
                                    <div style="font-size:.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Voted For</div>
                                    <div class="fw-semibold">{{ session('candidate_name', 'N/A') }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:38px;height:38px;background:#fef9c3;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-clock text-warning"></i>
                                </div>
                                <div>
                                    <div style="font-size:.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Voted At</div>
                                    <div class="fw-semibold">{{ session('voted_at', 'N/A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('voter.results', session('election_id')) }}" class="btn btn-primary px-4">
                            <i class="bi bi-bar-chart me-1"></i> View Results
                        </a>
                        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-house me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
