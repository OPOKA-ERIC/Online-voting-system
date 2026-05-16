@extends('layouts.admin')

@section('page-title', 'Upload Voters')
@section('page-icon', 'upload')
@section('page-subtitle', 'Bulk register voters by uploading a CSV or Excel file.')

@section('content')

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
    <div class="d-flex gap-3 mb-4 p-4 rounded-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1" style="color:#fca5a5;"></i>
        <ul style="color:#fca5a5;margin:0;padding-left:1rem;">
            @foreach($errors->all() as $error)<li style="font-size:.88rem;">{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="row g-4">

    {{-- ── Left: Upload Form ── --}}
    <div class="col-lg-8">
        <div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">

            {{-- Card header --}}
            <div class="p-4" style="background:rgba(34,197,94,0.08);border-bottom:1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;background:rgba(34,197,94,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-upload" style="color:#4ade80;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-white mb-0">Upload Voters File</h6>
                        <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Select an election and upload your voter list</p>
                    </div>
                </div>
            </div>

            <div class="p-4" style="background:rgba(255,255,255,0.02);">
                <form action="{{ route('admin.voters.upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Election select --}}
                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            <i class="bi bi-calendar2-check me-1" style="color:#6366f1;"></i>Select Election
                            <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="election_id" class="form-select form-select-lg" required>
                            <option value="">— Choose an election —</option>
                            @foreach($elections as $e)
                                <option value="{{ $e->id }}" {{ request('election_id') == $e->id ? 'selected' : '' }}>
                                    {{ $e->title }}
                                    ({{ $e->status === 'active' ? '🟢 Active' : ($e->status === 'upcoming' ? '🟡 Upcoming' : '🔴 Closed') }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Voters will be registered for this specific election.</div>
                    </div>

                    {{-- File drop zone --}}
                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            <i class="bi bi-file-earmark-arrow-up me-1" style="color:#4ade80;"></i>Select File
                            <span style="color:#ef4444;">*</span>
                        </label>

                        <div id="drop-zone" onclick="document.getElementById('voters_file').click()"
                             style="border:2px dashed rgba(255,255,255,0.12);border-radius:14px;padding:2.5rem;text-align:center;cursor:pointer;transition:all .2s;background:rgba(255,255,255,0.02);">
                            <i class="bi bi-cloud-arrow-up-fill d-block mb-2" style="font-size:2.2rem;color:rgba(255,255,255,0.2);"></i>
                            <div style="color:rgba(255,255,255,0.5);font-size:.88rem;">
                                Click to browse or drag & drop your file here
                            </div>
                            <div id="drop-filename" style="color:#4ade80;font-size:.82rem;margin-top:.5rem;display:none;"></div>
                            <div style="color:rgba(255,255,255,0.25);font-size:.75rem;margin-top:.4rem;">
                                CSV, Excel (.xlsx, .xls) — Max 5MB
                            </div>
                        </div>
                        <input type="file" id="voters_file" name="voters_file"
                               class="d-none" accept=".csv,.xlsx,.xls" required>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between align-items-center pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
                        <a href="{{ route('admin.elections.index') }}"
                           style="color:rgba(255,255,255,0.4);text-decoration:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;"
                           onmouseover="this.style.color='rgba(255,255,255,0.8)'"
                           onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                            <i class="bi bi-arrow-left"></i> Back to Elections
                        </a>
                        <button type="submit"
                                style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;padding:.7rem 2rem;font-size:.9rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:.5rem;transition:opacity .2s;"
                                onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                            <i class="bi bi-upload"></i> Upload Voters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Right: Guide + Example ── --}}
    <div class="col-lg-4 d-flex flex-column gap-4">

        {{-- Format guide --}}
        <div class="rounded-4 p-4" style="background:rgba(99,102,241,0.06);border:1px solid rgba(99,102,241,0.2);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-info-circle-fill" style="color:#a5b4fc;"></i>
                <h6 class="fw-bold text-white mb-0">File Format Guide</h6>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach([
                    ['bi-filetype-csv','emerald','CSV (.csv)','Recommended. Columns: name, email, password'],
                    ['bi-file-earmark-excel','green','Excel (.xlsx)','First row must be headers: name, email, password'],
                ] as [$icon, $color, $type, $desc])
                <div class="d-flex gap-3 align-items-start">
                    <div style="width:32px;height:32px;background:rgba(34,197,94,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi {{ $icon }}" style="color:#4ade80;font-size:.9rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:.82rem;font-weight:600;color:#fff;">{{ $type }}</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,0.4);line-height:1.5;">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CSV example --}}
        <div class="rounded-4 p-4" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.08);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-code-square" style="color:#67e8f9;"></i>
                <h6 class="fw-bold text-white mb-0">Example CSV</h6>
            </div>
            <div class="rounded-3 p-3" style="background:#070b14;border:1px solid rgba(255,255,255,0.07);">
                <code style="color:#4ade80;font-size:.8rem;line-height:1.9;display:block;">
                    name,email,password<br>
                    John Doe,john@uni.ac,pass123<br>
                    Jane Smith,jane@uni.ac,pass123<br>
                    Bob Ouma,bob@uni.ac,pass123
                </code>
            </div>
            <p style="color:rgba(255,255,255,0.3);font-size:.75rem;margin-top:.75rem;margin-bottom:0;">
                <i class="bi bi-shield-check me-1" style="color:#4ade80;"></i>
                Passwords are hashed automatically on import.
            </p>
        </div>

        {{-- Tips --}}
        <div class="rounded-4 p-4" style="background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.2);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-lightbulb-fill" style="color:#fcd34d;"></i>
                <h6 class="fw-bold text-white mb-0">Tips</h6>
            </div>
            <ul style="color:rgba(255,255,255,0.45);font-size:.82rem;line-height:2;padding-left:1.1rem;margin:0;">
                <li>Create the election before uploading voters</li>
                <li>Duplicate emails are skipped automatically</li>
                <li>Voters receive login credentials via email</li>
                <li>Max 5MB per file upload</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('voters_file');
    const dropFilename = document.getElementById('drop-filename');

    fileInput.addEventListener('change', function () {
        if (this.files[0]) {
            dropFilename.textContent = '✓ ' + this.files[0].name;
            dropFilename.style.display = 'block';
            dropZone.style.borderColor = 'rgba(34,197,94,0.5)';
            dropZone.style.background = 'rgba(34,197,94,0.04)';
        }
    });

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.style.borderColor = 'rgba(99,102,241,0.6)';
        dropZone.style.background = 'rgba(99,102,241,0.05)';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = 'rgba(255,255,255,0.12)';
        dropZone.style.background = 'rgba(255,255,255,0.02)';
    });

    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            dropFilename.textContent = '✓ ' + file.name;
            dropFilename.style.display = 'block';
            dropZone.style.borderColor = 'rgba(34,197,94,0.5)';
            dropZone.style.background = 'rgba(34,197,94,0.04)';
        }
    });
</script>
@endsection
