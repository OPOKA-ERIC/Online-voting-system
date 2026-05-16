@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div style="width:100%;max-width:560px;padding:0 1rem;">

        <!-- Success Animation -->
        <div class="text-center mb-4">
            <div id="success-icon" style="width:90px;height:90px;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;box-shadow:0 16px 40px rgba(34,197,94,0.35);transform:scale(0);transition:transform .4s cubic-bezier(.34,1.56,.64,1);">
                <i class="bi bi-check-lg text-white" style="font-size:2.5rem;"></i>
            </div>
            <h2 class="fw-bold text-white mb-2">All Votes Submitted!</h2>
            <p style="color:rgba(255,255,255,0.45);">Your votes have been securely recorded.</p>
        </div>

        <!-- Receipt Card -->
        <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:20px;overflow:hidden;margin-bottom:1.5rem;">

            <!-- Receipt Header -->
            <div style="background:linear-gradient(135deg,rgba(34,197,94,0.15),rgba(6,182,212,0.1));padding:1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="color:rgba(255,255,255,0.5);font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin:0;">Vote Receipt</p>
                    <p style="color:#fff;font-weight:600;font-size:.95rem;margin:.2rem 0 0;">{{ session('election_title', 'N/A') }}</p>
                </div>
                <div style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.3rem .8rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                    <i class="bi bi-check-circle-fill me-1"></i>Complete
                </div>
            </div>

            <!-- Votes List -->
            <div class="p-4">
                @php $allVotes = session('all_votes', []); @endphp

                @if(count($allVotes))
                    <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:1rem;">Your Selections</p>
                    @foreach($allVotes as $i => $vote)
                        <div class="d-flex align-items-center gap-3 {{ $i < count($allVotes) - 1 ? 'mb-3 pb-3' : '' }}"
                             style="{{ $i < count($allVotes) - 1 ? 'border-bottom:1px solid rgba(255,255,255,0.06);' : '' }}">
                            <div style="width:38px;height:38px;background:linear-gradient(135deg,rgba(99,102,241,0.3),rgba(139,92,246,0.3));border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.9rem;font-weight:700;color:#a5b4fc;">
                                {{ strtoupper(substr($vote['candidate'], 0, 1)) }}
                            </div>
                            <div style="flex:1;">
                                <p style="color:rgba(255,255,255,0.4);font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;margin:0;">{{ $vote['position'] }}</p>
                                <p style="color:#fff;font-weight:600;font-size:.92rem;margin:0;">{{ $vote['candidate'] }}</p>
                            </div>
                            <div style="text-align:right;">
                                <p style="color:rgba(255,255,255,0.3);font-size:.72rem;margin:0;">{{ $vote['voted_at'] }}</p>
                                <span style="color:#4ade80;font-size:.75rem;font-weight:600;"><i class="bi bi-check-circle-fill me-1"></i>Recorded</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback for single-vote session (legacy) -->
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:42px;height:42px;background:rgba(34,197,94,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-person-check-fill" style="color:#4ade80;"></i>
                        </div>
                        <div>
                            <p style="color:rgba(255,255,255,0.35);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;margin:0;">Voted For</p>
                            <p style="color:#fff;font-weight:600;margin:0;">{{ session('candidate_name', 'N/A') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Timestamp Footer -->
            <div style="background:rgba(255,255,255,0.02);border-top:1px solid rgba(255,255,255,0.06);padding:.75rem 1.5rem;display:flex;align-items:center;gap:.5rem;">
                <i class="bi bi-clock" style="color:rgba(255,255,255,0.3);font-size:.8rem;"></i>
                <span style="color:rgba(255,255,255,0.3);font-size:.78rem;">Submitted on {{ session('voted_at', now()->format('M d, Y h:i A')) }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-3">
            <a href="{{ route('voter.results', session('election_id')) }}"
               style="flex:1;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:12px;padding:.85rem;font-size:.9rem;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:opacity .2s;"
               onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <i class="bi bi-bar-chart-fill"></i> View Results
            </a>
            <a href="{{ route('voter.dashboard') }}"
               style="flex:1;background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:.85rem;font-size:.9rem;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                <i class="bi bi-house-fill"></i> Dashboard
            </a>
        </div>

    </div>
</div>

<!-- Confetti Canvas -->
<canvas id="confetti-canvas" style="position:fixed;inset:0;pointer-events:none;z-index:9999;"></canvas>

<script>
// Pop in the success icon
setTimeout(() => {
    document.getElementById('success-icon').style.transform = 'scale(1)';
}, 100);

// Minimal confetti
(function() {
    const canvas = document.getElementById('confetti-canvas');
    const ctx    = canvas.getContext('2d');
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;

    const colors  = ['#6366f1','#22c55e','#06b6d4','#f59e0b','#ec4899','#a5b4fc'];
    const pieces  = Array.from({ length: 80 }, () => ({
        x:    Math.random() * canvas.width,
        y:    Math.random() * -canvas.height,
        w:    6 + Math.random() * 6,
        h:    10 + Math.random() * 8,
        color: colors[Math.floor(Math.random() * colors.length)],
        speed: 2 + Math.random() * 3,
        angle: Math.random() * 360,
        spin:  (Math.random() - .5) * 4,
        drift: (Math.random() - .5) * 1.5,
    }));

    let frame = 0;
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(p => {
            ctx.save();
            ctx.translate(p.x + p.w / 2, p.y + p.h / 2);
            ctx.rotate(p.angle * Math.PI / 180);
            ctx.fillStyle = p.color;
            ctx.globalAlpha = Math.max(0, 1 - frame / 180);
            ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
            ctx.restore();
            p.y     += p.speed;
            p.x     += p.drift;
            p.angle += p.spin;
        });
        frame++;
        if (frame < 200) requestAnimationFrame(draw);
        else ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    draw();
})();
</script>
@endsection
