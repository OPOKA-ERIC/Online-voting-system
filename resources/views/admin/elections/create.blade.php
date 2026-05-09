@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white fw-bold">Create Election</div>
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

                    <form action="{{ route('admin.elections.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Positions / Posts Being Contested</label>
                            <div id="positions-wrapper">
                                <div class="input-group mb-2">
                                    <input type="text" name="positions[]" class="form-control" placeholder="e.g. Guild President">
                                    <button type="button" class="btn btn-outline-danger" onclick="removePosition(this)">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-1" onclick="addPosition()">
                                <i class="bi bi-plus-circle me-1"></i>Add Another Position
                            </button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.elections.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Election</button>
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
    div.innerHTML = `<input type="text" name="positions[]" class="form-control" placeholder="e.g. Woman MP"><button type="button" class="btn btn-outline-danger" onclick="removePosition(this)">Remove</button>`;
    wrapper.appendChild(div);
}
function removePosition(btn) {
    const wrapper = document.getElementById('positions-wrapper');
    if (wrapper.children.length > 1) {
        btn.closest('.input-group').remove();
    }
}
</script>
@endsection
