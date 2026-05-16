@extends('layouts.static')
@section('title', 'Security')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Trust & Safety</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Security at <span class="gradient-text">VoteSecure</span></h1>
<p class="text-slate-400 text-lg mb-12">Security isn't a feature — it's the foundation everything is built on.</p>

<div class="grid md:grid-cols-2 gap-6 mb-10">
    @foreach([
        ['bi-shield-lock', 'indigo', 'End-to-End Encryption', 'Every ballot is encrypted from the moment it leaves your device until it is tallied. No one — not even our staff — can read your vote.'],
        ['bi-link-45deg', 'violet', 'Blockchain Audit Trail', 'All election events are recorded on an immutable ledger. Independent auditors can verify results without accessing voter identities.'],
        ['bi-person-check', 'emerald', 'Voter Verification', 'Multi-factor identity verification ensures only eligible voters can participate. Biometric, email, and ID-based options available.'],
        ['bi-bug', 'amber', 'Penetration Testing', 'We conduct quarterly third-party penetration tests and maintain a public bug bounty program to continuously harden our platform.'],
        ['bi-cloud-check', 'sky', 'SOC 2 Type II Certified', 'Our infrastructure and processes are independently audited and certified to meet the highest standards for security and availability.'],
        ['bi-lock', 'rose', 'Zero-Knowledge Architecture', 'Our system is designed so that even a full database breach would reveal no voter identities or ballot contents.'],
    ] as [$icon, $color, $title, $desc])
    <div class="glass rounded-2xl p-6 flex gap-4">
        <div class="w-11 h-11 bg-{{ $color }}-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="bi {{ $icon }} text-{{ $color }}-400 text-xl"></i>
        </div>
        <div>
            <h3 class="font-semibold mb-1">{{ $title }}</h3>
            <p class="text-slate-400 text-sm">{{ $desc }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="glass rounded-2xl p-8 text-center">
    <h2 class="heading-font text-2xl font-semibold mb-3">Found a vulnerability?</h2>
    <p class="text-slate-400 mb-6 text-sm">We take security reports seriously. Responsible disclosure is rewarded through our bug bounty program.</p>
    <a href="{{ route('contact') }}" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 rounded-2xl font-semibold hover:brightness-110 transition">
        Report a Vulnerability
    </a>
</div>
@endsection
