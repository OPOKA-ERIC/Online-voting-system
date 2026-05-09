@extends('layouts.admin')

@section('page-title', 'Election Details')
@section('page-icon', 'calendar2-check')
@section('page-subtitle', 'Viewing details for this election.')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-calendar2-check me-2 text-warning"></i>{{ $election->title }}</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.voters.upload', ['election_id' => $election->id]) }}" class="btn btn-success btn-sm">
            <i class="bi bi-upload me-1"></i>Upload Voters
        </a>
        <a href="{{ route('admin.elections.edit', $election) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.elections.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

{{-- Election Info Card --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small style="color:rgba(255,255,255,0.4);">Title</small>
                <p class="fw-semibold text-white mb-0">{{ $election->title }}</p>
            </div>
            <div class="col-md-6">
                <small style="color:rgba(255,255,255,0.4);">Status</small>
                <p class="mb-0">
                    @if($election->status === 'active')
                        <span class="badge" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);">
                            <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Active
                        </span>
                    @elseif($election->status === 'upcoming')
                        <span class="badge" style="background:rgba(245,158,11,0.15);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);">
                            <i class="bi bi-clock me-1"></i>Upcoming
                        </span>
                    @else
                        <span class="badge" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.1);">
                            <i class="bi bi-lock me-1"></i>Closed
                        </span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <small style="color:rgba(255,255,255,0.4);">Start Date</small>
                <p class="text-white mb-0">{{ $election->start_date->format('D, d M Y — H:i') }}</p>
            </div>
            <div class="col-md-6">
                <small style="color:rgba(255,255,255,0.4);">End Date</small>
                <p class="text-white mb-0">{{ $election->end_date->format('D, d M Y — H:i') }}</p>
            </div>
            <div class="col-12">
                <small style="color:rgba(255,255,255,0.4);">Description</small>
                <p class="text-white mb-0">{{ $election->description ?? 'No description provided.' }}</p>
            </div>
            <div class="col-md-4">
                <small style="color:rgba(255,255,255,0.4);">Total Candidates</small>
                <p class="fw-bold text-warning mb-0" style="font-size:1.4rem;">{{ $election->candidates->count() }}</p>
            </div>
            <div class="col-md-4">
                <small style="color:rgba(255,255,255,0.4);">Total Votes Cast</small>
                <p class="fw-bold text-warning mb-0" style="font-size:1.4rem;">{{ $election->votes->count() }}</p>
            </div>
            <div class="col-md-4">
                <small style="color:rgba(255,255,255,0.4);">Registered Voters</small>
                <p class="fw-bold text-warning mb-0" style="font-size:1.4rem;">{{ $voters->count() }}</p>
            </div>
            <div class="col-12">
                <small style="color:rgba(255,255,255,0.4);">Positions / Posts Being Contested</small>
                @if($election->positions->count() > 0)
                    <div class="d-flex flex-wrap gap-2 mt-1">
                        @foreach($election->positions as $position)
                            <span class="badge" style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);font-size:.85rem;padding:.45em .9em;">{{ $position->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-white mb-0">No positions added.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Uploaded Voters Table --}}
@if($fileRows->count() > 0)
<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <h6 class="fw-bold text-white mb-0"><i class="bi bi-people me-2 text-warning"></i>Uploaded Voters ({{ $fileRows->count() }})</h6>
</div>
<div class="card">
    <div class="card-body p-0" style="background:transparent; overflow-x:auto;">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                    <th style="padding:1rem 1.2rem;">#</th>
                    @foreach($fileHeaders as $header)
                        <th style="text-transform:capitalize;">{{ str_replace('_', ' ', $header) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($fileRows as $index => $row)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                    <td style="padding:1rem 1.2rem; color:rgba(255,255,255,0.4);">{{ $index + 1 }}</td>
                    @foreach($fileHeaders as $header)
                        <td style="color:rgba(255,255,255,0.75); font-size:.88rem;">
                            @if(strtolower($header) === 'password')
                                <span style="color:rgba(255,255,255,0.3);">••••••••</span>
                            @else
                                {{ $row[$header] ?? '—' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@elseif($voters->count() > 0)
<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <h6 class="fw-bold text-white mb-0"><i class="bi bi-people me-2 text-warning"></i>Registered Voters ({{ $voters->count() }})</h6>
</div>
<div class="card">
    <div class="card-body p-0" style="background:transparent;">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                    <th style="padding:1rem 1.2rem;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Voted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voters as $voter)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                    <td style="padding:1rem 1.2rem; color:rgba(255,255,255,0.4);">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $voter->name }}</td>
                    <td style="color:rgba(255,255,255,0.6); font-size:.88rem;">{{ $voter->email }}</td>
                    <td>
                        @if($voter->is_active)
                            <span class="badge" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);">Active</span>
                        @else
                            <span class="badge" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.1);">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if($voter->votes->where('election_id', $election->id)->count() > 0)
                            <span class="badge" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);"><i class="bi bi-check-circle me-1"></i>Voted</span>
                        @else
                            <span class="badge" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.1);">Not Voted</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
