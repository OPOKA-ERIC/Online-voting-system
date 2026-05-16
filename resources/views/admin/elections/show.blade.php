@extends('layouts.admin')

@section('page-title', $election->title)
@section('page-icon', 'calendar2-check')
@section('page-subtitle', 'Viewing full details, voters, and results for this election.')

@section('content')

{{-- Action bar --}}
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2">
        @if($election->status === 'active')
            <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;">
                <span style="width:6px;height:6px;background:#4ade80;border-radius:50%;animation:pulse 1.5s infinite;"></span>Active
            </span>
        @elseif($election->status === 'upcoming')
            <span style="background:rgba(245,158,11,0.15);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                <i class="bi bi-clock me-1"></i>Upcoming
            </span>
        @else
            <span style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.1);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                <i class="bi bi-lock me-1"></i>Closed
            </span>
        @endif
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.voters.upload', ['election_id' => $election->id]) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-upload me-1"></i>Upload Voters
        </a>
        <a href="{{ route('admin.elections.edit', $election) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.elections.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-4">
    @foreach([
        ['bi-people-fill','indigo', $election->candidates->count(), 'Candidates'],
        ['bi-check2-square','emerald', $election->votes->count(), 'Votes Cast'],
        ['bi-person-check-fill','amber', $voters->count(), 'Registered Voters'],
        ['bi-bar-chart-fill','sky',
            $voters->count() > 0 ? round($election->votes->count() / $voters->count() * 100) . '%' : '0%',
            'Turnout'],
    ] as [$icon, $color, $val, $label])
    <div class="col-6 col-md-3">
        <div class="rounded-3 p-3 d-flex align-items-center gap-3"
             style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
            <div style="width:40px;height:40px;background:rgba({{ $color === 'indigo' ? '99,102,241' : ($color === 'emerald' ? '34,197,94' : ($color === 'amber' ? '245,158,11' : '14,165,233')) }},0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi {{ $icon }}" style="color:{{ $color === 'indigo' ? '#a5b4fc' : ($color === 'emerald' ? '#4ade80' : ($color === 'amber' ? '#fcd34d' : '#67e8f9')) }};font-size:1rem;"></i>
            </div>
            <div>
                <div style="font-size:1.5rem;font-weight:800;color:#fff;line-height:1;">{{ $val }}</div>
                <div style="font-size:.72rem;color:rgba(255,255,255,0.4);margin-top:2px;">{{ $label }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Info + Positions --}}
<div class="row g-4 mb-4">

    {{-- Election info --}}
    <div class="col-md-7">
        <div class="rounded-4 overflow-hidden h-100" style="border:1px solid rgba(255,255,255,0.08);">
            <div class="px-4 py-3 d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);">
                <i class="bi bi-info-circle" style="color:#67e8f9;"></i>
                <span style="font-weight:600;font-size:.88rem;color:#fff;">Election Details</span>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    @foreach([
                        ['Description', $election->description ?? 'No description provided.'],
                        ['Start Date', $election->start_date->format('D, d M Y — H:i')],
                        ['End Date', $election->end_date->format('D, d M Y — H:i')],
                    ] as [$label, $value])
                    <div class="col-12">
                        <div style="font-size:.7rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.25rem;">{{ $label }}</div>
                        <div style="color:#fff;font-size:.88rem;">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Positions --}}
    <div class="col-md-5">
        <div class="rounded-4 overflow-hidden h-100" style="border:1px solid rgba(255,255,255,0.08);">
            <div class="px-4 py-3 d-flex align-items-center justify-content-between" style="background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-award" style="color:#fcd34d;"></i>
                    <span style="font-weight:600;font-size:.88rem;color:#fff;">Positions</span>
                </div>
                <span style="background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.4);padding:.15rem .6rem;border-radius:50px;font-size:.72rem;">
                    {{ $election->positions->count() }}
                </span>
            </div>
            <div class="p-4">
                @if($election->positions->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($election->positions as $position)
                            <span style="background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.25);padding:.35rem .85rem;border-radius:8px;font-size:.82rem;font-weight:500;">
                                {{ $position->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p style="color:rgba(255,255,255,0.25);font-size:.85rem;margin:0;">No positions added.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Polls / Results per Position --}}
@if($election->positions->count() > 0)
<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <h6 class="fw-bold text-white mb-0"><i class="bi bi-bar-chart-fill me-2 text-warning"></i>Poll Results by Position</h6>
    <small style="color:rgba(255,255,255,0.35);">Total votes cast: {{ $election->votes->count() }}</small>
</div>
@foreach($election->positions as $position)
    @php
        $positionVotes = $election->votes->where('position_id', $position->id)->count();
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-white mb-0"><i class="bi bi-award me-2" style="color:#a5b4fc;"></i>{{ $position->name }}</h6>
                <span class="badge" style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);">{{ $positionVotes }} vote(s)</span>
            </div>
            @forelse($position->candidates as $candidate)
                @php
                    $candidateVotes = $election->votes->where('position_id', $position->id)->where('candidate_id', $candidate->id)->count();
                    $percentage = $positionVotes > 0 ? round($candidateVotes / $positionVotes * 100, 1) : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center gap-2">
                            @if($candidate->photo)
                                <img src="{{ asset('storage/'.$candidate->photo) }}" width="28" height="28" class="rounded-circle" style="object-fit:cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:28px;height:28px;background:rgba(99,102,241,0.3);font-size:.75rem;font-weight:700;color:#a5b4fc;">
                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                </div>
                            @endif
                            <span style="color:rgba(255,255,255,0.85);font-size:.88rem;font-weight:500;">{{ $candidate->name }}</span>
                        </div>
                        <span style="color:rgba(255,255,255,0.6);font-size:.85rem;">{{ $candidateVotes }} vote(s) &mdash; {{ $percentage }}%</span>
                    </div>
                    <div style="background:rgba(255,255,255,0.07);border-radius:50px;height:8px;overflow:hidden;">
                        <div style="width:{{ $percentage }}%;background:linear-gradient(90deg,#6366f1,#06b6d4);height:100%;border-radius:50px;transition:width .5s;"></div>
                    </div>
                </div>
            @empty
                <p style="color:rgba(255,255,255,0.3);font-size:.85rem;">No candidates added yet.</p>
            @endforelse
        </div>
    </div>
@endforeach
@endif

{{-- Voters table --}}
@if($fileRows->count() > 0)
<div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">
    <div class="px-4 py-3 d-flex align-items-center justify-content-between" style="background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people" style="color:#fcd34d;"></i>
            <span style="font-weight:600;font-size:.88rem;color:#fff;">Uploaded Voters</span>
        </div>
        <span style="background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.4);padding:.15rem .6rem;border-radius:50px;font-size:.72rem;">
            {{ $fileRows->count() }} records
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-color:rgba(255,255,255,0.8);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead style="background:rgba(255,255,255,0.03);">
                <tr>
                    <th style="padding:.8rem 1.2rem;color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">#</th>
                    @foreach($fileHeaders as $header)
                        <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">{{ str_replace('_', ' ', $header) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($fileRows as $index => $row)
                <tr>
                    <td style="padding:.85rem 1.2rem;color:rgba(255,255,255,0.3);font-size:.82rem;">{{ $index + 1 }}</td>
                    @foreach($fileHeaders as $header)
                        <td style="font-size:.85rem;">
                            @if(strtolower($header) === 'password')
                                <span style="color:rgba(255,255,255,0.2);">••••••••</span>
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
<div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">
    <div class="px-4 py-3 d-flex align-items-center justify-content-between" style="background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people" style="color:#fcd34d;"></i>
            <span style="font-weight:600;font-size:.88rem;color:#fff;">Registered Voters</span>
        </div>
        <span style="background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.4);padding:.15rem .6rem;border-radius:50px;font-size:.72rem;">
            {{ $voters->count() }} voters
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-color:rgba(255,255,255,0.8);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead style="background:rgba(255,255,255,0.03);">
                <tr>
                    <th style="padding:.8rem 1.2rem;color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">#</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">Name</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">Email</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;">Voted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voters as $voter)
                <tr>
                    <td style="padding:.85rem 1.2rem;color:rgba(255,255,255,0.3);font-size:.82rem;">{{ $loop->iteration }}</td>
                    <td style="font-weight:600;">{{ $voter->name }}</td>
                    <td style="color:rgba(255,255,255,0.5);font-size:.85rem;">{{ $voter->email }}</td>
                    <td>
                        @if($voter->votes->where('election_id', $election->id)->count() > 0)
                            <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.2rem .7rem;border-radius:50px;font-size:.72rem;font-weight:600;">
                                <i class="bi bi-check-circle me-1"></i>Voted
                            </span>
                        @else
                            <span style="background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.3);border:1px solid rgba(255,255,255,0.08);padding:.2rem .7rem;border-radius:50px;font-size:.72rem;font-weight:600;">
                                Pending
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else
<div class="text-center py-5 rounded-4" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.07);">
    <i class="bi bi-people d-block mb-3" style="font-size:2.5rem;color:rgba(255,255,255,0.12);"></i>
    <p style="color:rgba(255,255,255,0.25);margin:0;">
        No voters uploaded yet.
        <a href="{{ route('admin.voters.upload', ['election_id' => $election->id]) }}" style="color:#a5b4fc;">Upload voter list →</a>
    </p>
</div>
@endif

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>

@endsection
