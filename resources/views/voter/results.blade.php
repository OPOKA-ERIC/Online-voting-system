@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="p-4 mb-4 rounded-3 text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-sm btn-outline-light mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Elections
        </a>
        <h4 class="fw-bold mb-1">{{ $election->title }} — Results</h4>
        <p class="mb-0" style="color:rgba(255,255,255,0.6);font-size:.9rem;">
            Total votes cast: <strong class="text-white">{{ $totalVotes }}</strong>
        </p>
    </div>

    <!-- Chart Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Vote Distribution</h5>
            <canvas id="resultsChart" style="max-height:300px;"></canvas>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm">
        <div class="card-header fw-bold text-white" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);">
            <i class="bi bi-trophy me-2"></i>Candidate Standings
        </div>
        <div class="card-body p-0" style="background:transparent;">
            <table class="table mb-0 align-middle" style="--bs-table-bg:transparent;--bs-table-hover-bg:rgba(255,255,255,0.04);--bs-table-color:rgba(255,255,255,0.85);--bs-table-border-color:rgba(255,255,255,0.06);">
                <thead style="background:rgba(255,255,255,0.05);">
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                        <th style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;padding:1rem;width:50px;">#</th>
                        <th style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;">Candidate</th>
                        <th style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;">Votes</th>
                        <th style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;">Percentage</th>
                        <th style="color:rgba(255,255,255,0.4);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;width:30%;">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $i => $result)
                        <tr {{ $i === 0 && $totalVotes > 0 ? 'style=background:rgba(245,158,11,0.08);' : '' }}>
                            <td class="text-center">
                                @if($i === 0 && $totalVotes > 0)
                                    <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                @else
                                    <span class="text-muted fw-semibold">{{ $i + 1 }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($result['photo'])
                                        <img src="{{ asset('storage/' . $result['photo']) }}"
                                             class="rounded-circle" width="42" height="42" style="object-fit:cover; border:2px solid rgba(255,255,255,0.1);">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width:42px;height:42px;background:rgba(255,255,255,0.08);">
                                            <i class="bi bi-person-fill" style="color:rgba(255,255,255,0.4);"></i>
                                        </div>
                                    @endif
                                    <span class="fw-semibold">{{ $result['name'] }}</span>
                                    @if($i === 0 && $totalVotes > 0)
                                        <span class="badge bg-warning text-dark ms-1">Leading</span>
                                    @endif
                                </div>
                            </td>
                            <td><span class="badge bg-primary rounded-pill px-3">{{ $result['votes'] }}</span></td>
                            <td class="fw-semibold">{{ $result['percentage'] }}%</td>
                            <td>
                                <div class="progress" style="height:18px; border-radius:9px;">
                                    <div class="progress-bar {{ $i === 0 ? 'bg-warning' : 'bg-primary' }}"
                                         style="width:{{ $result['percentage'] }}%; border-radius:9px;">
                                        @if($result['percentage'] > 10){{ $result['percentage'] }}%@endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($totalVotes === 0)
            <div class="card-footer text-center text-muted py-4">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>No votes have been cast yet.
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json(collect($results)->pluck('name'));
    const data   = @json(collect($results)->pluck('votes'));
    const colors = ['#f59e0b','#6366f1','#06b6d4','#22c55e','#ef4444','#8b5cf6'];

    new Chart(document.getElementById('resultsChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Votes',
                data,
                backgroundColor: labels.map((_, i) => colors[i % colors.length] + 'cc'),
                borderColor:     labels.map((_, i) => colors[i % colors.length]),
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ctx.parsed.y + ' vote(s)' } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(255,255,255,0.4)' }, grid: { color: 'rgba(255,255,255,0.06)' } },
                x: { ticks: { color: 'rgba(255,255,255,0.4)' }, grid: { color: 'rgba(255,255,255,0.06)' } }
            }
        }
    });
</script>
@endsection
