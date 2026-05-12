@extends('layouts.admin')

@section('page-title', 'Candidates')
@section('page-icon', 'people-fill')
@section('page-subtitle', 'Manage all candidates grouped by election.')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold text-white mb-1">All Candidates</h5>
        <p style="color:rgba(255,255,255,0.35);font-size:.82rem;margin:0;">Grouped by election</p>
    </div>
    <a href="{{ route('admin.candidates.create') }}"
       style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;padding:.6rem 1.2rem;font-size:.88rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;transition:opacity .2s;"
       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-person-plus-fill"></i> Add Candidate
    </a>
</div>

@forelse($candidates->groupBy('election_id') as $electionId => $group)
    <div class="rounded-4 overflow-hidden mb-4" style="border:1px solid rgba(255,255,255,0.08);">
        <div class="p-3 d-flex align-items-center gap-3" style="background:rgba(245,158,11,0.08);border-bottom:1px solid rgba(245,158,11,0.15);">
            <div style="width:36px;height:36px;background:rgba(245,158,11,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-calendar2-check" style="color:#fcd34d;"></i>
            </div>
            <div class="flex-grow-1">
                <span style="color:#fff;font-weight:600;font-size:.92rem;">{{ $group->first()->election->title ?? 'Unknown Election' }}</span>
            </div>
            <span style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.45);padding:.2rem .7rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                {{ $group->count() }} candidate(s)
            </span>
        </div>
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.03);--bs-table-color:rgba(255,255,255,0.8);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead style="background:rgba(255,255,255,0.03);">
                <tr>
                    <th style="padding:.8rem 1.2rem;color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;width:50px;">#</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Candidate</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Position</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Bio</th>
                    <th style="color:rgba(255,255,255,0.3);font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group as $candidate)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
                    <td style="padding:.9rem 1.2rem;color:rgba(255,255,255,0.25);font-size:.82rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.1);">
                            @else
                                <div style="width:44px;height:44px;background:linear-gradient(135deg,rgba(99,102,241,0.3),rgba(139,92,246,0.3));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#a5b4fc;font-size:.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:#fff;">{{ $candidate->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($candidate->position)
                            <span style="background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.25);padding:.25rem .7rem;border-radius:6px;font-size:.78rem;font-weight:600;">{{ $candidate->position->name }}</span>
                        @else
                            <span style="color:rgba(255,255,255,0.2);font-size:.82rem;">—</span>
                        @endif
                    </td>
                    <td style="color:rgba(255,255,255,0.4);font-size:.82rem;">{{ Str::limit($candidate->bio, 55) ?? '—' }}</td>
                    <td style="text-align:center;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('admin.candidates.edit', $candidate) }}"
                               style="width:32px;height:32px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#a5b4fc;text-decoration:none;transition:all .2s;"
                               onmouseover="this.style.background='rgba(99,102,241,0.25)'" onmouseout="this.style.background='rgba(99,102,241,0.15)'">
                                <i class="bi bi-pencil" style="font-size:.8rem;"></i>
                            </a>
                            <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this candidate?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="width:32px;height:32px;background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fca5a5;cursor:pointer;transition:all .2s;"
                                        onmouseover="this.style.background='rgba(239,68,68,0.25)'" onmouseout="this.style.background='rgba(239,68,68,0.15)'">
                                    <i class="bi bi-trash" style="font-size:.8rem;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@empty
    <div class="text-center py-5 rounded-4" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.07);">
        <i class="bi bi-people d-block mb-3" style="font-size:2.5rem;color:rgba(255,255,255,0.15);"></i>
        <p style="color:rgba(255,255,255,0.25);">No candidates yet. <a href="{{ route('admin.candidates.create') }}" style="color:#a5b4fc;">Add the first candidate →</a></p>
    </div>
@endforelse
@endsection
