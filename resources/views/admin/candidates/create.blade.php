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
        <div class="rounded-4 overflow-hidden h-100" style="border:1px solid rgba(255,255,255,0.08);">

            <div class="p-4" style="background:rgba(99,102,241,0.08);border-bottom:1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-image" style="color:#a5b4fc;"></i>
                    <h6 class="fw-bold text-white mb-0">Candidate Photo</h6>
                </div>
            </div>

            <div class="p-4 d-flex flex-column align-items-center" style="background:rgba(255,255,255,0.02);">

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
                <div id="file-name" style="color:rgba(255,255,255,0.3);font-size:.78rem;margin-top:.5rem;">No file chosen</div>

                <hr class="w-100" style="border-color:rgba(255,255,255,0.08);">

                <ul style="color:rgba(255,255,255,0.35);font-size:.8rem;line-height:1.9;padding-left:1.1rem;margin:0;width:100%;">
                    <li>Clear face photo preferred</li>
                    <li>Minimum 200×200 pixels</li>
                    <li>Maximum file size: 2MB</li>
                    <li>Accepted: JPG, PNG, GIF</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ── Right Column: Candidate Details ── -->
    <div class="col-lg-8">
        <div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">

            <div class="p-4" style="background:rgba(245,158,11,0.08);border-bottom:1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;background:rgba(245,158,11,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-vcard" style="color:#fcd34d;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-white mb-0">Candidate Information</h6>
                        <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Fill in the candidate's details below</p>
                    </div>
                </div>
            </div>

            <div class="p-4" style="background:rgba(255,255,255,0.02);">

                <!-- Election -->
                <div class="mb-4">
                    <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                        <i class="bi bi-calendar2-check me-1" style="color:#6366f1;"></i>Election
                        <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="election_id" id="election_id" class="form-select form-select-lg" required>
                        <option value="">— Select an Election —</option>
                        @foreach($elections as $e)
                            <option value="{{ $e->id }}" {{ old('election_id') == $e->id ? 'selected' : '' }}
                                data-positions='{{ $e->positions->toJson() }}'>
                                {{ $e->title }}
                                ({{ $e->status === 'active' ? '🟢 Active' : ($e->status === 'upcoming' ? '🟡 Upcoming' : '🔴 Closed') }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Choose the election this candidate is running in.</div>
                </div>

                <!-- Position -->
                <div class="mb-4" id="position-wrapper" style="display:none;">
                    <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                        <i class="bi bi-award me-1" style="color:#f59e0b;"></i>Post Being Contested For
                        <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="position_id" id="position_id" class="form-select form-select-lg">
                        <option value="">— Select a Position —</option>
                    </select>
                    <div class="form-text">Select the post this candidate is contesting for.</div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                        <i class="bi bi-person me-1" style="color:#6366f1;"></i>Full Name
                        <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="name" class="form-control form-control-lg"
                           placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                    <div class="form-text">Enter the candidate's full legal name.</div>
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                        <i class="bi bi-file-text me-1" style="color:#6366f1;"></i>Biography
                    </label>
                    <textarea name="bio" class="form-control" rows="6"
                              placeholder="Write a short biography about the candidate — their background, qualifications, and goals...">{{ old('bio') }}</textarea>
                    <div class="form-text">Optional. A brief description shown to voters.</div>
                </div>

                <!-- Info note -->
                <div class="mb-4 p-3 rounded-3 d-flex gap-2 align-items-start"
                     style="background:rgba(6,182,212,0.08);border:1px solid rgba(6,182,212,0.2);">
                    <i class="bi bi-info-circle-fill mt-1" style="color:#67e8f9;flex-shrink:0;"></i>
                    <div style="font-size:.83rem;color:rgba(255,255,255,0.55);">
                        Once saved, the candidate will appear on the voting page for the selected election.
                        Make sure all details are correct before submitting.
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <a href="{{ route('admin.candidates.index') }}"
                       style="color:rgba(255,255,255,0.4);text-decoration:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;"
                       onmouseover="this.style.color='rgba(255,255,255,0.8)'"
                       onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                        <i class="bi bi-arrow-left"></i> Back to Candidates
                    </a>
                    <button type="submit"
                            style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:10px;padding:.7rem 2rem;font-size:.9rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:.5rem;transition:opacity .2s;"
                            onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-check-circle-fill"></i> Save Candidate
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
    // Photo preview
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

    // Load positions when election is selected
    document.getElementById('election_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const positionWrapper = document.getElementById('position-wrapper');
        const positionSelect  = document.getElementById('position_id');
        const positions = JSON.parse(selected.dataset.positions || '[]');

        positionSelect.innerHTML = '<option value="">— Select a Position —</option>';

        if (positions.length > 0) {
            positions.forEach(function (p) {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.name;
                positionSelect.appendChild(opt);
            });
            positionWrapper.style.display = 'block';
        } else {
            positionWrapper.style.display = 'none';
        }
    });
</script>
@endsection
