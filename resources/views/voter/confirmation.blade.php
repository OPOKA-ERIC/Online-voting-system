@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div style="width:100%;max-width:520px;padding:0 1rem;">

        <!-- Success Animation -->
        <div class="text-center mb-4">
            <div style="width:90px;height:90px;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;box-shadow:0 16px 40px rgba(34,197,94,0.35);">
                <i class="bi bi-check-lg text-white" style="font-size:2.5rem;"></i>
            </div>
            <h2 class="fw-bold text-white mb-2">Vote Submitted!</h2>
            <p style="color:rgba(255,255,255,0.45);">Your vote has been securely recorded.</p>
        </div>

        <!-- Details Card -->
        <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:20px;overflow:hidden;margin-bottom:1.5rem;">
            <div style="background:linear-gradient(135deg,rgba(34,197,94,0.15),rgba(6,182,212,0.1));padding:1.2rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.08);">
                <p style="color:rgba(255,255,255,0.5);font-size:.78rem;text-transform:uppercase;letter-spacing:.1em;margin:0;">Vote Receipt</p>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:42px;height:42px;background:rgba(99,102,241,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-calendar2-check" style="color:#a5b4fc;"></i>
                    </div>
                    <div>
                        <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;margin:0;">Election</p>
                        <p style="color:#fff;font-weight:600;margin:0;">{{ session('election_title', 'N/A') }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:42px;height:42px;background:rgba(34,197,94,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-person-check-fill" style="color:#4ade80;"></i>
                    </div>
                    <div>
                        <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;margin:0;">Voted For</p>
                        <p style="color:#fff;font-weight:600;margin:0;">{{ session('candidate_name', 'N/A') }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:rgba(245,158,11,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-clock-fill" style="color:#fcd34d;"></i>
                    </div>
                    <div>
                        <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;margin:0;">Timestamp</p>
                        <p style="color:#fff;font-weight:600;margin:0;">{{ session('voted_at', now()->format('Y-m-d H:i:s')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-3">
            <a href="{{ route('voter.results', session('election_id')) }}"
               style="flex:1;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:12px;padding:.85rem;font-size:.9rem;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:opacity .2s;"
               onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <i class="bi bi-bar-chart-fill"></i> View Results
            </a>
            <a href="{{ route('voter.dashboard') }}"
               style="flex:1;background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:.85rem;font-size:.9rem;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                <i class="bi bi-house-fill"></i> Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
