@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="mb-5 p-4 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,#1e3a5f,#0f172a);">
        <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:rgba(99,102,241,0.1);border-radius:50%;"></div>
        <a href="{{ route('voter.dashboard') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,0.5);font-size:.85rem;text-decoration:none;margin-bottom:1rem;transition:color .2s;"
           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
            <i class="bi bi-arrow-left"></i> Back to Elections
        </a>
        <h3 class="fw-bold text-white mb-1">{{ $election->title }}</h3>
        <p style="color:rgba(255,255,255,0.5);font-size:.9rem;margin:0;">{{ $election->description ?? 'Select your preferred candidate for each position.' }}</p>
    </div>

    @if(session('success'))
        <div class="d-flex align-items-center gap-3 mb-4 p-4" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);border-radius:12px;color:#86efac;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="d-flex align-items-center gap-3 mb-4 p-4" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @forelse($election->positions as $position)
        @php $alreadyVotedHere = in_array($position->id, $votedPositionIds); @endphp

        <div class="mb-5">
            <!-- Position Header -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-person-badge-fill text-white"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-white mb-0">{{ $position->name }}</h5>
                    <p style="color:rgba(255,255,255,0.4);font-size:.82rem;margin:0;">{{ $position->candidates->count() }} candidate(s) running</p>
                </div>
                @if($alreadyVotedHere)
                    <span class="ms-auto" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.3rem .9rem;border-radius:50px;font-size:.78rem;font-weight:600;">
                        <i class="bi bi-check-circle-fill me-1"></i>Voted
                    </span>
                @endif
            </div>

            @if($alreadyVotedHere)
                <div class="p-4 d-flex align-items-center gap-3" style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:14px;">
                    <i class="bi bi-check-circle-fill fs-4" style="color:#4ade80;"></i>
                    <div>
                        <p class="fw-semibold mb-0" style="color:#4ade80;">Vote Recorded</p>
                        <p style="color:rgba(255,255,255,0.4);font-size:.83rem;margin:0;">You have already cast your vote for <strong style="color:rgba(255,255,255,0.7);">{{ $position->name }}</strong>.</p>
                    </div>
                </div>
            @else
                <form action="{{ route('voter.cast') }}" method="POST">
                    @csrf
                    <input type="hidden" name="election_id" value="{{ $election->id }}">
                    <input type="hidden" name="position_id" value="{{ $position->id }}">

                    <div class="row g-3 mb-4">
                        @forelse($position->candidates as $candidate)
                            <div class="col-md-4 col-sm-6">
                                <label style="cursor:pointer;display:block;height:100%;">
                                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}" class="d-none candidate-radio-{{ $position->id }}" required>
                                    <div class="candidate-card-{{ $position->id }} text-center p-4 h-100"
                                         style="background:rgba(255,255,255,0.04);border:2px solid rgba(255,255,255,0.08);border-radius:16px;transition:all .2s;position:relative;">

                                        @if($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                 style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.1);margin:0 auto 1rem;display:block;">
                                        @else
                                            <div style="width:90px;height:90px;background:linear-gradient(135deg,rgba(99,102,241,0.3),rgba(139,92,246,0.3));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:2rem;font-weight:700;color:#a5b4fc;">
                                                {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <h6 class="fw-bold text-white mb-1">{{ $candidate->name }}</h6>
                                        <p style="color:rgba(255,255,255,0.4);font-size:.82rem;line-height:1.5;margin-bottom:1rem;">{{ Str::limit($candidate->bio ?? 'No biography provided.', 80) }}</p>

                                        <div class="select-btn-{{ $position->id }}" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:8px;padding:.4rem .8rem;font-size:.8rem;font-weight:600;color:rgba(255,255,255,0.5);display:inline-flex;align-items:center;gap:.4rem;">
                                            <i class="bi bi-circle"></i> Select
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="p-4 text-center" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:12px;color:rgba(255,255,255,0.3);">
                                    No candidates added for this position yet.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($position->candidates->count())
                        <button type="submit"
                                style="width:100%;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:12px;padding:.85rem;font-size:.95rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:opacity .2s;"
                                onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'"
                                onclick="return confirm('Submit your vote for {{ $position->name }}? This cannot be undone.')">
                            <i class="bi bi-check2-square"></i> Cast Vote for {{ $position->name }}
                        </button>
                    @endif
                </form>
            @endif
        </div>

        @if(!$loop->last)
            <div style="border-top:1px solid rgba(255,255,255,0.07);margin-bottom:2rem;"></div>
        @endif

    @empty
        <div class="text-center py-5" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:20px;">
            <i class="bi bi-people" style="font-size:2.5rem;color:rgba(255,255,255,0.2);display:block;margin-bottom:1rem;"></i>
            <p style="color:rgba(255,255,255,0.3);">No positions have been set up for this election yet.</p>
        </div>
    @endforelse

</div>

<script>
document.querySelectorAll('[class*="candidate-radio-"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const classes = Array.from(this.classList);
        const radioClass = classes.find(c => c.startsWith('candidate-radio-'));
        if (!radioClass) return;
        const posId = radioClass.replace('candidate-radio-', '');
        document.querySelectorAll(`.candidate-card-${posId}`).forEach(card => {
            card.style.borderColor = 'rgba(255,255,255,0.08)';
            card.style.background  = 'rgba(255,255,255,0.04)';
        });
        document.querySelectorAll(`.select-btn-${posId}`).forEach(btn => {
            btn.style.background   = 'rgba(255,255,255,0.06)';
            btn.style.borderColor  = 'rgba(255,255,255,0.1)';
            btn.style.color        = 'rgba(255,255,255,0.5)';
            btn.innerHTML          = '<i class="bi bi-circle"></i> Select';
        });
        const card = this.closest('label').querySelector(`[class*="candidate-card-"]`);
        const btn  = this.closest('label').querySelector(`[class*="select-btn-"]`);
        if (card) { card.style.borderColor = '#6366f1'; card.style.background = 'rgba(99,102,241,0.12)'; }
        if (btn)  { btn.style.background = '#6366f1'; btn.style.borderColor = '#6366f1'; btn.style.color = '#fff'; btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Selected'; }
    });
});
</script>
@endsection
