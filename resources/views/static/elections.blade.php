@extends('layouts.static')
@section('title', 'Elections')
@section('content')

@php
    $elections = \App\Models\Election::withCount(['candidates','votes'])
        ->orderByRaw("CASE WHEN status = 'active' THEN 0 WHEN status = 'upcoming' THEN 1 ELSE 2 END")
        ->latest()
        ->get();
@endphp

<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Live & Upcoming</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">
    Current <span class="gradient-text">Elections</span>
</h1>
<p class="text-slate-400 text-lg mb-10">
    Browse all active and upcoming elections on the VoteSecure platform.
    Log in to cast your vote.
</p>

@if($elections->isEmpty())
    <div class="glass rounded-2xl p-12 text-center">
        <i class="bi bi-calendar-x text-5xl block mb-4" style="color:rgba(255,255,255,0.15)"></i>
        <p class="text-slate-400">No elections are currently scheduled.</p>
        <a href="{{ route('register') }}" class="inline-block mt-4 px-6 py-3 rounded-2xl text-sm font-semibold"
           style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">
            Create an Election
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($elections as $election)
        @php
            $statusColor = match($election->status) {
                'active'   => ['bg'=>'rgba(34,197,94,0.12)','border'=>'rgba(34,197,94,0.3)','text'=>'#4ade80','dot'=>true],
                'upcoming' => ['bg'=>'rgba(245,158,11,0.12)','border'=>'rgba(245,158,11,0.3)','text'=>'#fcd34d','dot'=>false],
                default    => ['bg'=>'rgba(255,255,255,0.05)','border'=>'rgba(255,255,255,0.1)','text'=>'rgba(255,255,255,0.35)','dot'=>false],
            };
        @endphp
        <div class="glass rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5
                    hover:border-indigo-500/30 transition-colors duration-300">
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.2)">
                    <i class="bi bi-calendar2-check" style="color:#a5b4fc;font-size:1.1rem"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <h3 class="font-semibold text-white text-base">{{ $election->title }}</h3>
                        <!-- Status badge -->
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
                              style="background:{{ $statusColor['bg'] }};border:1px solid {{ $statusColor['border'] }};color:{{ $statusColor['text'] }}">
                            @if($statusColor['dot'])
                                <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:{{ $statusColor['text'] }}"></span>
                            @else
                                <i class="bi bi-{{ $election->status === 'upcoming' ? 'clock' : 'lock' }} text-[10px]"></i>
                            @endif
                            {{ ucfirst($election->status) }}
                        </span>
                    </div>
                    @if($election->description)
                        <p class="text-slate-400 text-sm mb-2">{{ Str::limit($election->description, 80) }}</p>
                    @endif
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                        <span><i class="bi bi-calendar-event me-1" style="color:#6366f1"></i>
                            {{ $election->start_date->format('M d, Y') }} — {{ $election->end_date->format('M d, Y') }}
                        </span>
                        <span><i class="bi bi-people me-1" style="color:#4ade80"></i>
                            {{ $election->candidates_count }} candidate{{ $election->candidates_count !== 1 ? 's' : '' }}
                        </span>
                        <span><i class="bi bi-check2-square me-1" style="color:#fcd34d"></i>
                            {{ number_format($election->votes_count) }} vote{{ $election->votes_count !== 1 ? 's' : '' }} cast
                        </span>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="flex-shrink-0">
                @if($election->status === 'active')
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:brightness-110"
                       style="background:linear-gradient(135deg,#6366f1,#8b5cf6);box-shadow:0 4px 16px rgba(99,102,241,0.3)">
                        <i class="bi bi-box-arrow-in-right"></i> Vote Now
                    </a>
                @elseif($election->status === 'upcoming')
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium"
                          style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);color:#fcd34d">
                        <i class="bi bi-clock"></i> Opens {{ $election->start_date->diffForHumans() }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium"
                          style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.35)">
                        <i class="bi bi-lock"></i> Closed
                    </span>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Summary strip -->
    <div class="mt-8 grid grid-cols-3 gap-4">
        @foreach([
            [$elections->where('status','active')->count(),   'Active Now',  'bi-circle-fill',    '#4ade80'],
            [$elections->where('status','upcoming')->count(),  'Upcoming',    'bi-clock-fill',     '#fcd34d'],
            [$elections->where('status','closed')->count(),    'Closed',      'bi-lock-fill',      'rgba(255,255,255,0.3)'],
        ] as [$count, $label, $icon, $color])
        <div class="glass rounded-2xl p-4 text-center">
            <i class="bi {{ $icon }} text-xl block mb-1" style="color:{{ $color }}"></i>
            <div class="text-white font-bold text-xl">{{ $count }}</div>
            <div class="text-slate-500 text-xs">{{ $label }}</div>
        </div>
        @endforeach
    </div>
@endif

@endsection
