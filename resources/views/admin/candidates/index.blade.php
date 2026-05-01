@extends('layouts.admin')

@section('page-title', 'Candidates')
@section('page-icon', 'people-fill')
@section('page-subtitle', 'Manage all candidates grouped by election.')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-people-fill me-2 text-warning"></i>All Candidates</h5>
    <a href="{{ route('admin.candidates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> New Candidate
    </a>
</div>

@forelse($candidates->groupBy('election_id') as $electionId => $group)
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center gap-2" style="background:rgba(245,158,11,0.1); border-bottom:1px solid rgba(245,158,11,0.2);">
            <i class="bi bi-calendar2-check text-warning"></i>
            <span class="fw-semibold text-white">{{ $group->first()->election->title ?? 'Unknown Election' }}</span>
            <span class="badge ms-auto" style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.5);">
                {{ $group->count() }} candidate(s)
            </span>
        </div>
        <div class="card-body p-0" style="background:transparent;">
            <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.04);--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
                <thead>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                        <th style="padding:1rem 1.2rem;">#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Bio</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group as $candidate)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:1rem 1.2rem; color:rgba(255,255,255,0.4);">{{ $loop->iteration }}</td>
                        <td>
                            @if($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}"
                                     alt="{{ $candidate->name }}"
                                     class="rounded-circle" width="42" height="42"
                                     style="object-fit:cover; border:2px solid rgba(255,255,255,0.1);">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:42px;height:42px;background:rgba(255,255,255,0.08);">
                                    <i class="bi bi-person-fill" style="color:rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $candidate->name }}</td>
                        <td style="color:rgba(255,255,255,0.5); font-size:.88rem;">{{ Str::limit($candidate->bio, 60) }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this candidate?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="card p-5 text-center">
        <i class="bi bi-people d-block mb-3" style="font-size:2.5rem;color:rgba(255,255,255,0.2);"></i>
        <p style="color:rgba(255,255,255,0.3);">No candidates found.</p>
    </div>
@endforelse
@endsection
