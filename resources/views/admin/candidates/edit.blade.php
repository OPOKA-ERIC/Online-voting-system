@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark fw-bold">Edit Candidate</div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.candidates.update', $candidate) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Election</label>
                            <select name="election_id" class="form-select" required>
                                <option value="">-- Select Election --</option>
                                @foreach($elections as $e)
                                    <option value="{{ $e->id }}"
                                        {{ old('election_id', $candidate->election_id) == $e->id ? 'selected' : '' }}>
                                        {{ $e->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $candidate->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            @if($candidate->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $candidate->photo) }}"
                                         alt="{{ $candidate->name }}" width="80" height="80"
                                         class="rounded" style="object-fit:cover;">
                                    <small class="text-muted ms-2">Current photo — upload a new one to replace it</small>
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $candidate->bio) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.candidates.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Candidate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
