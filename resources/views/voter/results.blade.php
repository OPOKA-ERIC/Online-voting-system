@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <h3 class="fw-bold mb-0">{{ $election->title }} — Results</h3>
        <p class="text-muted mt-1">Total votes cast: <strong>{{ $totalVotes }}</strong></p>
    </div>

    {{-- Bar Chart --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Vote Distribution</h5>
            <canvas id="resultsChart"></canvas>
        </div>
    </div>

    {{-- Results Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">Candidate Standings</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Candidate</th>
                        <th>Votes</th>
                        <th>Percentage</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $i => $result)
                        <tr>
                            <td>
                                @if($i === 0 && $totalVotes > 0)
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($result['photo'])
                                        <img src="{{ asset('storage/' . $result['photo']) }}"
                                             class="rounded-circle" width="35" height="35" style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                             style="width:35px;height:35px;">
                                            <i class="bi bi-person-fill text-white small"></i>
                                        </div>
                                    @endif
                                    <span class="fw-semibold">{{ $result['name'] }}</span>
                                </div>
                            </td>
                            <td><span class="badge bg-primary">{{ $result['votes'] }}</span></td>
                            <td>{{ $result['percentage'] }}%</td>
                            <td style="width:30%">
                                <div class="progress" style="height:16px;">
                                    <div class="progress-bar bg-primary" style="width:{{ $result['percentage'] }}%">
                                        {{ $result['percentage'] }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($results->pluck('name'));
    const data = @json($results->pluck('votes'));
    new Chart(document.getElementById('resultsChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Votes',
                data,
                backgroundColor: 'rgba(21,101,192,0.7)',
                borderColor: 'rgba(21,101,192,1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ctx.parsed.y + ' vote(s)' } }
            },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endsection
