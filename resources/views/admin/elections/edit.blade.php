@extends('layouts.admin')

@section('page-title', 'Edit Election')
@section('page-icon', 'pencil-square')
@section('page-subtitle', 'Update the details for this election.')

@section('content')

@if($errors->any())
    <div class="d-flex gap-3 mb-4 p-4 rounded-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1" style="color:#fca5a5;"></i>
        <ul style="color:#fca5a5;margin:0;padding-left:1rem;">
            @foreach($errors->all() as $error)<li style="font-size:.88rem;">{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="rounded-4 overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">

            {{-- Card header --}}
            <div class="p-4" style="background:rgba(245,158,11,0.08);border-bottom:1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;background:rgba(245,158,11,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-pencil-square" style="color:#fcd34d;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-white mb-0">Election Details</h6>
                        <p style="color:rgba(255,255,255,0.35);font-size:.78rem;margin:0;">Update the information below</p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="p-4" style="background:rgba(255,255,255,0.02);">
                <form action="{{ route('admin.elections.update', $election) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            Election Title <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="title" class="form-control form-control-lg"
                               placeholder="e.g. Guild Presidential Elections 2025"
                               value="{{ old('title', $election->title) }}" required>
                    </div>

                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            Description
                        </label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Brief description of this election...">{{ old('description', $election->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            <i class="bi bi-award me-1" style="color:#f59e0b;"></i>Positions / Posts Being Contested
                        </label>
                        <div id="positions-wrapper" class="d-flex flex-column gap-2">
                            @foreach($election->positions as $position)
                            <div class="d-flex gap-2 position-row">
                                <input type="hidden" name="position_ids[]" value="{{ $position->id }}">
                                <input type="text" name="position_names[]" class="form-control"
                                       value="{{ $position->name }}" placeholder="e.g. Guild President">
                                <button type="button" onclick="removePosition(this)"
                                        style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:8px;padding:.5rem .8rem;cursor:pointer;flex-shrink:0;transition:all .2s;"
                                        onmouseover="this.style.background='rgba(239,68,68,0.25)'"
                                        onmouseout="this.style.background='rgba(239,68,68,0.15)'">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            @endforeach

                            {{-- Empty row if no positions --}}
                            @if($election->positions->isEmpty())
                            <div class="d-flex gap-2 position-row">
                                <input type="hidden" name="position_ids[]" value="">
                                <input type="text" name="position_names[]" class="form-control" placeholder="e.g. Guild President">
                                <button type="button" onclick="removePosition(this)"
                                        style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:8px;padding:.5rem .8rem;cursor:pointer;flex-shrink:0;transition:all .2s;"
                                        onmouseover="this.style.background='rgba(239,68,68,0.25)'"
                                        onmouseout="this.style.background='rgba(239,68,68,0.15)'">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <button type="button" onclick="addPosition()" class="mt-2 d-inline-flex align-items-center gap-2"
                                style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.25);color:#4ade80;border-radius:8px;padding:.45rem 1rem;font-size:.82rem;font-weight:600;cursor:pointer;transition:all .2s;"
                                onmouseover="this.style.background='rgba(34,197,94,0.18)'"
                                onmouseout="this.style.background='rgba(34,197,94,0.1)'">
                            <i class="bi bi-plus-circle-fill"></i> Add Another Position
                        </button>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                                <i class="bi bi-calendar-event me-1" style="color:#6366f1;"></i>Start Date <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                   value="{{ old('start_date', $election->start_date->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                                <i class="bi bi-calendar-x me-1" style="color:#ef4444;"></i>End Date <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="datetime-local" name="end_date" class="form-control"
                                   value="{{ old('end_date', $election->end_date->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
                        <a href="{{ route('admin.elections.index') }}"
                           style="color:rgba(255,255,255,0.4);text-decoration:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;"
                           onmouseover="this.style.color='rgba(255,255,255,0.8)'"
                           onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                        <button type="submit"
                                style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:none;border-radius:10px;padding:.7rem 2rem;font-size:.9rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:.5rem;transition:opacity .2s;"
                                onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                            <i class="bi bi-check-circle-fill"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tips sidebar --}}
    <div class="col-lg-4">
        <div class="rounded-4 p-4 mb-4" style="background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.2);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-lightbulb-fill" style="color:#fcd34d;"></i>
                <h6 class="fw-bold text-white mb-0">Tips</h6>
            </div>
            <ul style="color:rgba(255,255,255,0.5);font-size:.83rem;line-height:2;padding-left:1.2rem;margin:0;">
                <li>Changing dates won't affect votes already cast</li>
                <li>Removing a position also removes its candidates</li>
                <li>Status updates automatically based on dates</li>
                <li>Upload a new voter list from the election detail page</li>
            </ul>
        </div>

        {{-- Current status card --}}
        <div class="rounded-4 p-4" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-info-circle" style="color:#67e8f9;"></i>
                <h6 class="fw-bold text-white mb-0">Current Status</h6>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach([
                    ['bi-calendar-event','Start', $election->start_date->format('M d, Y — H:i')],
                    ['bi-calendar-x','End', $election->end_date->format('M d, Y — H:i')],
                    ['bi-people','Candidates', $election->candidates->count().' registered'],
                    ['bi-check2-square','Votes Cast', $election->votes->count().' votes'],
                ] as [$icon, $label, $value])
                <div class="d-flex align-items-center gap-3">
                    <div style="width:30px;height:30px;background:rgba(255,255,255,0.05);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi {{ $icon }}" style="color:rgba(255,255,255,0.35);font-size:.8rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:.7rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:.08em;">{{ $label }}</div>
                        <div style="font-size:.83rem;color:#fff;font-weight:500;">{{ $value }}</div>
                    </div>
                </div>
                @endforeach
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
    div.className = 'd-flex gap-2 position-row';
    div.innerHTML = `
        <input type="hidden" name="position_ids[]" value="">
        <input type="text" name="position_names[]" class="form-control" placeholder="e.g. Secretary General">
        <button type="button" onclick="removePosition(this)"
                style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:8px;padding:.5rem .8rem;cursor:pointer;flex-shrink:0;"
                onmouseover="this.style.background='rgba(239,68,68,0.25)'"
                onmouseout="this.style.background='rgba(239,68,68,0.15)'">
            <i class="bi bi-trash"></i>
        </button>`;
    wrapper.appendChild(div);
}
function removePosition(btn) {
    const wrapper = document.getElementById('positions-wrapper');
    if (wrapper.children.length > 1) btn.closest('.position-row').remove();
}
</script>
@endsection
