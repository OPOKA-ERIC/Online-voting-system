@extends('layouts.admin')

@section('page-title', 'Upload Voters')
@section('page-icon', 'upload')
@section('page-subtitle', 'Bulk register voters by uploading a CSV or Excel file.')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header" style="background:rgba(34,197,94,0.1); border-bottom:1px solid rgba(34,197,94,0.2);">
                <i class="bi bi-upload me-2 text-success"></i>
                <span class="fw-semibold text-white">Upload Voters File</span>
            </div>
            <div class="card-body p-4">

                <!-- Format Guide -->
                <div class="mb-4 p-3 rounded" style="background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.2);">
                    <p class="fw-semibold mb-2" style="color:#a5b4fc;"><i class="bi bi-info-circle me-2"></i>File Format Guide</p>
                    <ul class="mb-0 ps-3" style="color:rgba(255,255,255,0.6); font-size:.88rem; line-height:2;">
                        <li><strong class="text-white">CSV (.csv)</strong> — Recommended. Columns: <code style="background:rgba(255,255,255,0.08);padding:.1rem .4rem;border-radius:4px;">name, email, password</code></li>
                        <li><strong class="text-white">Excel (.xlsx, .xls)</strong> — First row must be headers: <code style="background:rgba(255,255,255,0.08);padding:.1rem .4rem;border-radius:4px;">name, email, password</code></li>
                        <li><strong class="text-white">PDF / Word</strong> — Accepted for record keeping only, voters won't be auto-imported</li>
                    </ul>
                </div>

                <!-- CSV Example -->
                <div class="mb-4 p-3 rounded" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08);">
                    <p class="fw-semibold mb-2" style="color:rgba(255,255,255,0.5); font-size:.82rem; text-transform:uppercase; letter-spacing:.05em;">Example CSV Format</p>
                    <code style="color:#4ade80; font-size:.85rem;">
                        name,email,password<br>
                        John Doe,john@example.com,password123<br>
                        Jane Smith,jane@example.com,password123
                    </code>
                </div>

                <form action="{{ route('admin.voters.upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Select Election</label>
                        <select name="election_id" class="form-select" required>
                            <option value="">— Choose an election —</option>
                            @foreach($elections as $e)
                                <option value="{{ $e->id }}" {{ request('election_id') == $e->id ? 'selected' : '' }}>
                                    {{ $e->title }} ({{ $e->status }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Voters will be registered for this specific election.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Select File</label>
                        <input type="file" name="voters_file" class="form-control"
                               accept=".csv,.xlsx,.xls,.pdf,.doc,.docx" required>
                        <div class="form-text">Accepted: CSV, Excel (.xlsx, .xls), PDF, Word (.doc, .docx) — Max 5MB</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color:rgba(255,255,255,0.08)!important;">
                        <a href="{{ route('admin.elections.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-upload me-2"></i>Upload Voters
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
