@extends('layouts.static')
@section('title', 'About Us')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Our Story</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-6">Built for <span class="gradient-text">democracy</span></h1>
<p class="text-slate-400 text-lg mb-8">
    VoteSecure was founded with a single mission: make every vote count, securely and transparently.
    We believe that access to fair elections is a fundamental right — and technology should make that easier, not harder.
</p>
<p class="text-slate-400 text-lg mb-12">
    From student council elections to national referendums, our platform has powered over 142 elections
    with zero security breaches. We're a team of engineers, designers, and democracy advocates committed
    to building the most trusted voting infrastructure in the world.
</p>

<div class="grid md:grid-cols-3 gap-6 mb-12">
    @foreach([
        ['248k+', 'Voters served'],
        ['142', 'Elections run'],
        ['99.9%', 'Uptime SLA'],
    ] as [$stat, $label])
    <div class="glass rounded-2xl p-6 text-center">
        <div class="text-4xl font-bold gradient-text mb-2">{{ $stat }}</div>
        <div class="text-slate-400 text-sm">{{ $label }}</div>
    </div>
    @endforeach
</div>

<div class="glass rounded-2xl p-8">
    <h2 class="heading-font text-2xl font-semibold mb-4">Our Values</h2>
    <div class="space-y-4">
        @foreach([
            ['🔒', 'Security First', 'We never compromise on security. Every feature is designed with privacy and integrity at its core.'],
            ['🌍', 'Accessibility', 'Voting should be easy for everyone, regardless of device, language, or technical ability.'],
            ['🔍', 'Transparency', 'Our audit trails are open. Voters and observers can verify results independently.'],
        ] as [$icon, $title, $desc])
        <div class="flex gap-4">
            <span class="text-2xl">{{ $icon }}</span>
            <div>
                <div class="font-semibold mb-1">{{ $title }}</div>
                <p class="text-slate-400 text-sm">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
