@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark fw-bold">Edit Election</div>
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

                    <form action="{{ route('admin.elections.update', $election) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $election->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $election->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Positions / Posts Being Contested</label>
                            <div id="positions-wrapper">
                                @foreach($election->positions as $position)
                                <div class="input-group mb-2">
                                    <input type="hidden" name="position_ids[]" value="{{ $position->id }}">
                                    <input type="text" name="position_names[]" class="form-control"
                                           value="{{ $position->name }}" placeholder="e.g. Guild President">
                                    <button type="button" class="btn btn-outline-danger" onclick="removePosition(this)">Remove</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-1" onclick="addPosition()">
                                <i class="bi bi-plus-circle me-1"></i>Add Another Position
                            </button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                   value="{{ old('start_date', $election->start_date->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" class="form-control"
                                   value="{{ old('end_date', $election->end_date->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.elections.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Election</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function addPosition() {
    const wrapper = document.getElementById('positions-wrapper');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="hidden" name="position_ids[]" value="">
                     <input type="text" name="position_names[]" class="form-control" placeholder="e.g. Woman MP">
                     <button type="button" class="btn btn-outline-danger" onclick="removePosition(this)">Remove</button>`;
    wrapper.appendChild(div);
}
function removePosition(btn) {
    btn.closest('.input-group').remove();
}
</script>
@endsection
