@extends('layouts.admin')

@section('page-title', 'Add Candidate')
@section('page-icon', 'person-plus-fill')
@section('page-subtitle', 'Register a new candidate for an election.')

@section('content')

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex gap-2 align-items-start mb-4">
        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('admin.candidates.store') }}" enctype="multipart/form-data" id="candidateForm">
@csrf

<div class="row g-4">

    <!-- ── Left Column: Photo Upload ── -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-image me-2"></i>Candidate Photo
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">

                <div id="photo-preview-wrap" class="w-100 mb-3" onclick="document.getElementById('photo').click()">
                    <img id="photo-preview" src="" alt="Preview">
                    <div class="upload-placeholder" id="upload-placeholder">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        <p>Click to upload photo</p>
                        <small class="text-muted">JPG, PNG, GIF — max 2MB</small>
                    </div>
                </div>

                <input type="file" name="photo" id="photo" class="d-none" accept="image/*">

                <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                        onclick="document.getElementById('photo').click()">
                    <i class="bi bi-upload me-1"></i> Choose Photo
                </button>
                <div id="file-name" class="text-muted mt-2" style="font-size:.8rem;">No file chosen</div>

                <hr class="w-100">

                <div class="w-100">
                    <p class="text-muted mb-2" style="font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em;">Photo Guidelines</p>
                    <ul class="text-muted ps-3 mb-0" style="font-size:.82rem; line-height:1.8;">
                        <li>Clear face photo preferred</li>
                        <li>Minimum 200×200 pixels</li>
                        <li>Maximum file size: 2MB</li>
                        <li>Accepted: JPG, PNG, GIF</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Right Column: Candidate Details ── -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person-vcard me-2"></i>Candidate Information
            </div>
            <div class="card-body p-4">

                <!-- Election -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-calendar2-check me-1 text-primary"></i>Election
                        <span class="text-danger">*</span>
                    </label>
                    <select name="election_id" class="form-select form-select-lg" required>
                        <option value="">— Select an Election —</option>
                        @foreach($elections as $e)
                            <option value="{{ $e->id }}" {{ old('election_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->title }}
                                ({{ $e->status === 'active' ? '🟢 Active' : ($e->status === 'upcoming' ? '🟡 Upcoming' : '🔴 Closed') }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Choose the election this candidate is running in.</div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-person me-1 text-primary"></i>Full Name
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control form-control-lg"
                           placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                    <div class="form-text">Enter the candidate's full legal name.</div>
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-file-text me-1 text-primary"></i>Biography
                    </label>
                    <textarea name="bio" class="form-control" rows="6"
                              placeholder="Write a short biography about the candidate — their background, qualifications, and goals...">{{ old('bio') }}</textarea>
                    <div class="form-text">Optional. A brief description shown to voters.</div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info d-flex gap-2 align-items-start mb-4">
                    <i class="bi bi-info-circle-fill mt-1"></i>
                    <div style="font-size:.85rem;">
                        <strong>Note:</strong> Once saved, the candidate will appear on the voting page for the selected election.
                        Make sure all details are correct before submitting.
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <a href="{{ route('admin.candidates.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Candidates
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-check-circle me-2"></i>Save Candidate
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
</form>

@endsection

@section('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        document.getElementById('file-name').textContent = file.name;

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('upload-placeholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
