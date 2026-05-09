@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white fw-bold">Upload Voters</div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="text-muted mb-3">Upload a file to bulk-register voters. Supported formats:</p>
                    <ul class="text-muted mb-3" style="font-size:.9rem;">
                        <li><strong>CSV (.csv)</strong> — Recommended. Columns: <code>name, email, password</code></li>
                        <li><strong>Excel (.xlsx, .xls)</strong> — First row must be headers: <code>name, email, password</code></li>
                        <li><strong>PDF / Word (.pdf, .doc, .docx)</strong> — Accepted for record keeping only, data cannot be auto-imported</li>
                    </ul>

                    <form action="{{ route('admin.voters.upload.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="election_id" value="{{ request('election_id') }}">
                        <div class="mb-3">
                            <label class="form-label">CSV File</label>
                            <input type="file" name="voters_file" class="form-control" accept=".csv,.xlsx,.xls,.pdf,.doc,.docx" required>
                            <small class="text-muted">Accepted formats: CSV, Excel (.xlsx, .xls), PDF, Word (.doc, .docx)</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.elections.create') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Upload Voters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
