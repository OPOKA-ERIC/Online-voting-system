@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Candidates</h2>
        <a href="{{ route('admin.candidates.create') }}" class="btn btn-primary">+ New Candidate</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($candidates->groupBy('election_id') as $electionId => $group)
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white fw-bold">
                {{ $group->first()->election->title ?? 'Unknown Election' }}
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Bio</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $candidate)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}"
                                         alt="{{ $candidate->name }}"
                                         class="rounded-circle" width="45" height="45" style="object-fit:cover;">
                                @else
                                    <span class="badge bg-secondary">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $candidate->name }}</td>
                            <td>{{ Str::limit($candidate->bio, 60) }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this candidate?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No candidates found.</div>
    @endforelse
</div>
@endsection
