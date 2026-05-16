@extends('layouts.static')
@section('title', 'Changelog')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Updates</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Changelog</h1>
<p class="text-slate-400 text-lg mb-12">What's new in VoteSecure — every improvement, fix, and feature.</p>

<div class="space-y-10">
    @foreach([
        ['v2.4.0', 'May 2025', 'emerald', [
            'Added biometric login support (fingerprint & face ID)',
            'Real-time result streaming via WebSockets',
            'New admin bulk voter import via CSV/XLSX',
        ]],
        ['v2.3.0', 'March 2025', 'indigo', [
            'Position-based ballot system',
            'Voter verification flow with unique voter IDs',
            'Improved mobile ballot UI',
        ]],
        ['v2.2.0', 'January 2025', 'violet', [
            'Blockchain audit trail for all votes',
            'Email & SMS reminders for voters',
            'Dark mode dashboard',
        ]],
        ['v2.0.0', 'November 2024', 'amber', [
            'Complete platform rewrite with Laravel 11',
            'New glassmorphism UI design system',
            'Multi-election support',
        ]],
    ] as [$version, $date, $color, $items])
    <div class="flex gap-6">
        <div class="flex flex-col items-center">
            <div class="w-3 h-3 rounded-full bg-{{ $color }}-400 mt-1.5 flex-shrink-0"></div>
            <div class="w-px flex-1 bg-white/10 mt-2"></div>
        </div>
        <div class="pb-8 flex-1">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-white font-semibold text-lg">{{ $version }}</span>
                <span class="text-slate-500 text-sm">{{ $date }}</span>
            </div>
            <ul class="space-y-2">
                @foreach($items as $item)
                <li class="flex items-start gap-2 text-slate-300 text-sm">
                    <i class="bi bi-plus-circle text-{{ $color }}-400 mt-0.5"></i>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</div>
@endsection
