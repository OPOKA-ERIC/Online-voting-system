@extends('layouts.admin')

@section('page-title', 'Elections')
@section('page-icon', 'calendar2-check')
@section('page-subtitle', 'Manage all elections in the system.')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-calendar2-check me-2 text-warning"></i>All Elections</h5>
    <a href="{{ route('admin.elections.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> New Election
    </a>
</div>

<div class="card">
    <div class="card-body p-0" style="background:transparent;">
        <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.04);--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <th style="padding:1rem 1.2rem;">#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elections as $election)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding:1rem 1.2rem; color:rgba(255,255,255,0.4);">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $election->title }}</td>
                    <td style="color:rgba(255,255,255,0.5); font-size:.88rem;">{{ Str::limit($election->description, 50) }}</td>
                    <td style="color:rgba(255,255,255,0.6); font-size:.88rem;">{{ $election->start_date->format('Y-m-d H:i') }}</td>
                    <td style="color:rgba(255,255,255,0.6); font-size:.88rem;">{{ $election->end_date->format('Y-m-d H:i') }}</td>
                    <td>
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
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.elections.edit', $election) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.elections.destroy', $election) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this election?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:rgba(255,255,255,0.3);">
                        <i class="bi bi-calendar-x d-block mb-2" style="font-size:2rem;"></i>
                        No elections found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
