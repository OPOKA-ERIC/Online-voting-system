@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-icon', 'speedometer2')
@section('page-subtitle', 'Overview of the Online Voting System.')

@section('content')

<div class="row g-4">

    <!-- Elections -->
    <div class="col-sm-6 col-lg-3">
        <div class="card h-100" style="border:1px solid rgba(99,102,241,0.3); background:rgba(99,102,241,0.08);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:46px;height:46px;background:rgba(99,102,241,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-calendar2-check" style="color:#a5b4fc;font-size:1.2rem;"></i>
                    </div>
                    <span class="badge" style="background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);">Total</span>
                </div>
                <div class="display-5 fw-bold text-white mb-1">{{ $elections }}</div>
                <div style="color:rgba(255,255,255,0.45);font-size:.85rem;">Elections</div>
            </div>
        </div>
    </div>

    <!-- Candidates -->
    <div class="col-sm-6 col-lg-3">
        <div class="card h-100" style="border:1px solid rgba(34,197,94,0.3); background:rgba(34,197,94,0.08);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:46px;height:46px;background:rgba(34,197,94,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-people-fill" style="color:#4ade80;font-size:1.2rem;"></i>
                    </div>
                    <span class="badge" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);">Total</span>
                </div>
                <div class="display-5 fw-bold text-white mb-1">{{ $candidates }}</div>
                <div style="color:rgba(255,255,255,0.45);font-size:.85rem;">Candidates</div>
            </div>
        </div>
    </div>

    <!-- Voters -->
    <div class="col-sm-6 col-lg-3">
        <div class="card h-100" style="border:1px solid rgba(245,158,11,0.3); background:rgba(245,158,11,0.08);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:46px;height:46px;background:rgba(245,158,11,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-check-fill" style="color:#fcd34d;font-size:1.2rem;"></i>
                    </div>
                    <span class="badge" style="background:rgba(245,158,11,0.15);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);">Total</span>
                </div>
                <div class="display-5 fw-bold text-white mb-1">{{ $voters }}</div>
                <div style="color:rgba(255,255,255,0.45);font-size:.85rem;">Registered Voters</div>
            </div>
        </div>
    </div>

    <!-- Votes -->
    <div class="col-sm-6 col-lg-3">
        <div class="card h-100" style="border:1px solid rgba(239,68,68,0.3); background:rgba(239,68,68,0.08);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:46px;height:46px;background:rgba(239,68,68,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-check2-square" style="color:#fca5a5;font-size:1.2rem;"></i>
                    </div>
                    <span class="badge" style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);">Total</span>
                </div>
                <div class="display-5 fw-bold text-white mb-1">{{ $votes }}</div>
                <div style="color:rgba(255,255,255,0.45);font-size:.85rem;">Votes Cast</div>
            </div>
        </div>
    </div>

</div>

<!-- Quick Links -->
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card p-4 d-flex flex-row align-items-center gap-4">
            <div style="width:52px;height:52px;background:rgba(99,102,241,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-calendar2-plus" style="color:#a5b4fc;font-size:1.3rem;"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold text-white mb-1">Manage Elections</div>
                <div style="color:rgba(255,255,255,0.4);font-size:.85rem;">Create, edit or delete elections</div>
            </div>
            <a href="{{ route('admin.elections.index') }}" class="btn btn-sm btn-outline-primary">View</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 d-flex flex-row align-items-center gap-4">
            <div style="width:52px;height:52px;background:rgba(34,197,94,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-person-plus-fill" style="color:#4ade80;font-size:1.3rem;"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold text-white mb-1">Manage Candidates</div>
                <div style="color:rgba(255,255,255,0.4);font-size:.85rem;">Add or remove candidates</div>
            </div>
            <a href="{{ route('admin.candidates.index') }}" class="btn btn-sm btn-outline-primary">View</a>
        </div>
    </div>
</div>

@endsection
