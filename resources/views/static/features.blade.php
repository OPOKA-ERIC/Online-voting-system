@extends('layouts.static')
@section('title', 'Features')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Platform</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-6">Everything you need to run <span class="gradient-text">trusted elections</span></h1>
<p class="text-slate-400 text-lg mb-12">VoteSecure is packed with powerful tools that make online voting secure, transparent, and effortless for both admins and voters.</p>

<div class="space-y-6">
    @foreach([
        ['🔒','Military-grade Security','End-to-end encryption, blockchain audit trail, biometric options, and zero-knowledge proofs keep every ballot tamper-proof.'],
        ['📊','Real-time Analytics','Live dashboards show turnout, participation rates, and instant result visualizations the moment polls close.'],
        ['📱','Mobile First','Fully responsive on every device. SMS & email reminders. Offline ballot queuing for low-connectivity areas.'],
        ['✅','Voter Verification','Multi-factor identity checks including national ID, student email, and biometric login options.'],
        ['🔗','Immutable Audit Trail','Every action is logged on an append-only ledger — fully auditable by independent observers.'],
        ['⚡','Instant Results','Results are tallied and published automatically the moment the election closes — no manual counting.'],
    ] as [$icon, $title, $desc])
    <div class="glass rounded-2xl p-6 flex gap-5">
        <div class="text-3xl mt-1">{{ $icon }}</div>
        <div>
            <h3 class="font-semibold text-lg mb-1">{{ $title }}</h3>
            <p class="text-slate-400 text-sm">{{ $desc }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-12 text-center">
    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 rounded-3xl font-semibold text-lg hover:brightness-110 transition-all">
        Get Started Free
    </a>
</div>
@endsection
