@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="p-4 mb-5 rounded-4 position-relative overflow-hidden" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);">
        <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:rgba(99,102,241,0.08);border-radius:50%;"></div>
        <a href="{{ route('voter.dashboard') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,0.5);font-size:.85rem;text-decoration:none;margin-bottom:1rem;transition:color .2s;"
           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
            <i class="bi bi-arrow-left"></i> Back to Elections
        </a>
        <h3 class="fw-bold text-white mb-1">{{ $election->title }} — Results</h3>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span style="color:rgba(255,255,255,0.45);font-size:.88rem;">
                <i class="bi bi-bar-chart-fill me-1" style="color:#6366f1;"></i>
                Total votes cast: <strong class="text-white">{{ $totalVotes }}</strong>
            </span>
            @if(now() <= $election->end_date)
                <span style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);padding:.2rem .7rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                    <i class="bi bi-circle-fill me-1" style="font-size:.4rem;vertical-align:middle;"></i>LIVE
                </span>
            @else
                <span style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.12);padding:.2rem .7rem;border-radius:50px;font-size:.75rem;font-weight:600;">
                    CLOSED
                </span>
            @endif
        </div>
    </div>

    @forelse($resultsByPosition as $group)
        @php $candidates = $group['candidates']; $posTotal = $group['total']; @endphp

        <div class="mb-5">
            <!-- Position Title -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-person-badge-fill text-white"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-white mb-0">{{ $group['position'] }}</h5>
                    <p style="color:rgba(255,255,255,0.4);font-size:.82rem;margin:0;">{{ $posTotal }} vote(s) cast for this position</p>
                </div>
            </div>

            <!-- Chart -->
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:1.5rem;margin-bottom:1.2rem;">
                <canvas id="chart-{{ $loop->index }}" style="max-height:220px;"></canvas>
            </div>

            <!-- Candidates Table -->
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:16px;overflow:hidden;">
                <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
                    <thead>
                        <tr style="background:rgba(255,255,255,0.04);border-bottom:1px solid rgba(255,255,255,0.08);">
                            <th style="color:rgba(255,255,255,0.4);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;padding:1rem;width:44px;">#</th>
                            <th style="color:rgba(255,255,255,0.4);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;">Candidate</th>
                            <th style="color:rgba(255,255,255,0.4);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;">Votes</th>
                            <th style="color:rgba(255,255,255,0.4);font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;width:35%;">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $i => $c)
                            <tr style="{{ $c['is_my_vote'] ? 'background:rgba(99,102,241,0.1);' : ($i === 0 && $posTotal > 0 ? 'background:rgba(245,158,11,0.07);' : '') }}">
                                <td class="text-center">
                                    @if($i === 0 && $posTotal > 0)
                                        <i class="bi bi-trophy-fill text-warning"></i>
                                    @else
                                        <span style="color:rgba(255,255,255,0.3);font-weight:600;">{{ $i + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($c['photo'])
                                            <img src="{{ asset('storage/' . $c['photo']) }}" class="rounded-circle" width="40" height="40" style="object-fit:cover;border:2px solid rgba(255,255,255,0.1);">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:rgba(255,255,255,0.07);flex-shrink:0;">
                                                <i class="bi bi-person-fill" style="color:rgba(255,255,255,0.35);"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="fw-semibold">{{ $c['name'] }}</span>
                                            <div class="d-flex gap-2 mt-1">
                                                @if($i === 0 && $posTotal > 0)
                                                    <span class="badge bg-warning text-dark" style="font-size:.68rem;">Leading</span>
                                                @endif
                                                @if($c['is_my_vote'])
                                                    <span style="background:rgba(99,102,241,0.25);color:#a5b4fc;border:1px solid rgba(99,102,241,0.4);border-radius:50px;font-size:.68rem;font-weight:600;padding:.1rem .5rem;">
                                                        <i class="bi bi-hand-index-fill me-1"></i>Your Vote
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="background:rgba(99,102,241,0.2);color:#a5b4fc;border-radius:50px;padding:.25rem .75rem;font-size:.82rem;font-weight:600;">
                                        {{ $c['votes'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex:1;height:8px;background:rgba(255,255,255,0.07);border-radius:99px;overflow:hidden;">
                                            <div style="height:100%;width:{{ $c['percentage'] }}%;background:{{ $c['is_my_vote'] ? 'linear-gradient(90deg,#6366f1,#8b5cf6)' : ($i === 0 ? 'linear-gradient(90deg,#f59e0b,#d97706)' : 'linear-gradient(90deg,#06b6d4,#0284c7)') }};border-radius:99px;transition:width .6s;"></div>
                                        </div>
                                        <span style="color:rgba(255,255,255,0.6);font-size:.82rem;font-weight:600;min-width:38px;">{{ $c['percentage'] }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($posTotal === 0)
                    <div class="text-center py-4" style="color:rgba(255,255,255,0.25);">
                        <i class="bi bi-inbox d-block fs-3 mb-2"></i>No votes cast for this position yet.
                    </div>
                @endif
            </div>
        </div>

        @if(!$loop->last)
            <div style="border-top:1px solid rgba(255,255,255,0.06);margin-bottom:3rem;"></div>
        @endif

    @empty
        <div class="text-center py-5" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:20px;">
            <i class="bi bi-bar-chart" style="font-size:2.5rem;color:rgba(255,255,255,0.2);display:block;margin-bottom:1rem;"></i>
            <p style="color:rgba(255,255,255,0.3);">No positions found for this election.</p>
        </div>
    @endforelse

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const colors  = ['#f59e0b','#6366f1','#06b6d4','#22c55e','#ef4444','#8b5cf6'];
const myColor = '#6366f1';

@foreach($resultsByPosition as $i => $group)
(function() {
    const labels = @json(collect($group['candidates'])->pluck('name'));
    const data   = @json(collect($group['candidates'])->pluck('votes'));
    const isMyVote = @json(collect($group['candidates'])->pluck('is_my_vote'));

    const bgColors     = labels.map((_, idx) => isMyVote[idx] ? 'rgba(99,102,241,0.7)' : (colors[idx % colors.length] + 'bb'));
    const borderColors = labels.map((_, idx) => isMyVote[idx] ? '#6366f1' : colors[idx % colors.length]);

    new Chart(document.getElementById('chart-{{ $i }}'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Votes',
                data,
                backgroundColor: bgColors,
                borderColor: borderColors,
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const suffix = isMyVote[ctx.dataIndex] ? ' (Your Vote)' : '';
                            return ctx.parsed.y + ' vote(s)' + suffix;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(255,255,255,0.4)' }, grid: { color: 'rgba(255,255,255,0.06)' } },
                x: { ticks: { color: 'rgba(255,255,255,0.4)' }, grid: { color: 'rgba(255,255,255,0.06)' } }
            }
        }
    });
})();
@endforeach
</script>
@endsection
