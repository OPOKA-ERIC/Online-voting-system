@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Elections</h2>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-primary">+ New Election</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
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
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $election->title }}</td>
                        <td>{{ Str::limit($election->description, 50) }}</td>
                        <td>{{ $election->start_date->format('Y-m-d H:i') }}</td>
                        <td>{{ $election->end_date->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($election->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($election->status === 'upcoming')
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.elections.edit', $election) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.elections.destroy', $election) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this election?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No elections found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
