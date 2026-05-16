@extends('layouts.admin')

@section('page-title', 'Elections')
@section('page-icon', 'calendar2-check')
@section('page-subtitle', 'Manage all elections in the system.')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold text-white mb-1">All Elections</h5>
        <p style="color:rgba(255,255,255,0.35);font-size:.82rem;margin:0;">{{ \App\Models\Election::count() }} total elections in the system</p>
    </div>
    <a href="{{ route('admin.elections.create') }}"
       style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:10px;padding:.6rem 1.2rem;font-size:.88rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;transition:opacity .2s;"
       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-plus-circle-fill"></i> New Election
    </a>
</div>

<div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">
    <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.03);--bs-table-color:rgba(255,255,255,0.8);--bs-table-border-color:rgba(255,255,255,0.06);">
        <thead style="background:rgba(255,255,255,0.05);">
            <tr>
                <th style="padding:1rem 1.2rem;color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">#</th>
                <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Election</th>
                <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Period</th>
                <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Status</th>
                <th style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($elections as $election)
            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                <td style="padding:1rem 1.2rem;color:rgba(255,255,255,0.25);font-size:.82rem;">{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('admin.elections.show', $election) }}" style="text-decoration:none;">
                        <div style="font-weight:600;color:#fff;margin-bottom:.2rem;">{{ $election->title }}</div>
                    </a>
                    <div style="color:rgba(255,255,255,0.35);font-size:.78rem;">{{ $election->candidates->count() }} candidate(s)</div>
                </td>
                <td>
                    <div style="color:rgba(255,255,255,0.6);font-size:.82rem;"><i class="bi bi-calendar-event me-1" style="color:#6366f1;"></i>{{ $election->start_date->format('M d, Y') }}</div>
                    <div style="color:rgba(255,255,255,0.35);font-size:.78rem;"><i class="bi bi-calendar-x me-1" style="color:#ef4444;"></i>{{ $election->end_date->format('M d, Y') }}</div>
                </td>
                <td>
                    @if($election->status === 'active')
                        <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;">
                            <span style="width:6px;height:6px;background:#4ade80;border-radius:50%;animation:pulse 1.5s infinite;"></span>Active
                        </span>
                    @elseif($election->status === 'upcoming')
                        <span style="background:rgba(245,158,11,0.15);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                            <i class="bi bi-clock me-1"></i>Upcoming
                        </span>
                    @else
                        <span style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.35);border:1px solid rgba(255,255,255,0.1);padding:.3rem .9rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                            <i class="bi bi-lock me-1"></i>Closed
                        </span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="{{ route('admin.elections.show', $election) }}"
                           style="width:32px;height:32px;background:rgba(6,182,212,0.15);border:1px solid rgba(6,182,212,0.3);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#67e8f9;text-decoration:none;transition:all .2s;"
                           title="View" onmouseover="this.style.background='rgba(6,182,212,0.25)'" onmouseout="this.style.background='rgba(6,182,212,0.15)'">
                            <i class="bi bi-eye" style="font-size:.8rem;"></i>
                        </a>
                        <a href="{{ route('admin.elections.edit', $election) }}"
                           style="width:32px;height:32px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#a5b4fc;text-decoration:none;transition:all .2s;"
                           title="Edit" onmouseover="this.style.background='rgba(99,102,241,0.25)'" onmouseout="this.style.background='rgba(99,102,241,0.15)'">
                            <i class="bi bi-pencil" style="font-size:.8rem;"></i>
                        </a>
                        <form action="{{ route('admin.elections.destroy', $election) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this election?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="width:32px;height:32px;background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fca5a5;cursor:pointer;transition:all .2s;"
                                    title="Delete" onmouseover="this.style.background='rgba(239,68,68,0.25)'" onmouseout="this.style.background='rgba(239,68,68,0.15)'">
                                <i class="bi bi-trash" style="font-size:.8rem;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:4rem;color:rgba(255,255,255,0.2);">
                    <i class="bi bi-calendar-x d-block mb-3" style="font-size:2.5rem;"></i>
                    <p style="margin:0;">No elections found. <a href="{{ route('admin.elections.create') }}" style="color:#a5b4fc;">Create your first election →</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>
@endsection
