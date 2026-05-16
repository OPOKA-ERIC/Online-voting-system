@extends('layouts.static')
@section('title', 'Roadmap')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">What's Coming</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Product <span class="gradient-text">Roadmap</span></h1>
<p class="text-slate-400 text-lg mb-12">Here's what we're building next. Transparency is core to everything we do.</p>

<div class="space-y-4">
    @foreach([
        ['In Progress', 'indigo', 'bi-arrow-repeat', [
            ['Zero-knowledge proof voting', 'Cryptographic privacy without sacrificing verifiability.'],
            ['Multi-language support', 'Full i18n for 20+ languages including Swahili, French, and Arabic.'],
        ]],
        ['Coming Soon', 'amber', 'bi-clock', [
            ['Mobile app (iOS & Android)', 'Native apps with push notifications and offline voting.'],
            ['API v2 with webhooks', 'Programmatic access to elections, results, and voter data.'],
            ['White-label solution', 'Fully branded voting portals for enterprise clients.'],
        ]],
        ['Planned', 'slate', 'bi-calendar3', [
            ['AI-powered fraud detection', 'Machine learning models to flag suspicious voting patterns.'],
            ['Ranked-choice voting', 'Support for preferential and instant-runoff ballot types.'],
        ]],
    ] as [$status, $color, $icon, $items])
    <div class="glass rounded-2xl p-6">
        <div class="flex items-center gap-2 mb-5">
            <i class="bi {{ $icon }} text-{{ $color }}-400"></i>
            <span class="text-{{ $color }}-400 text-sm font-semibold tracking-widest uppercase">{{ $status }}</span>
        </div>
        <div class="space-y-4">
            @foreach($items as [$title, $desc])
            <div class="flex gap-4 items-start">
                <div class="w-2 h-2 rounded-full bg-{{ $color }}-400 mt-2 flex-shrink-0"></div>
                <div>
                    <div class="font-medium text-white">{{ $title }}</div>
                    <div class="text-slate-400 text-sm">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection
