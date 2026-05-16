@extends('layouts.static')
@section('title', 'Press Kit')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Media</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Press <span class="gradient-text">Kit</span></h1>
<p class="text-slate-400 text-lg mb-12">Everything journalists and media partners need to cover VoteSecure.</p>

<div class="space-y-8">
    <div class="glass rounded-2xl p-6">
        <h2 class="font-semibold text-lg mb-3">About VoteSecure</h2>
        <p class="text-slate-400 text-sm leading-relaxed">
            VoteSecure is a modern online voting platform that provides military-grade security, real-time analytics,
            and a seamless voter experience. Founded to make democratic participation accessible and trustworthy,
            VoteSecure has powered 142+ elections serving 248,000+ voters with zero security breaches.
        </p>
    </div>

    <div class="glass rounded-2xl p-6">
        <h2 class="font-semibold text-lg mb-4">Brand Assets</h2>
        <div class="grid grid-cols-2 gap-4">
            @foreach(['Logo (SVG)', 'Logo (PNG)', 'Icon (SVG)', 'Brand Guidelines PDF'] as $asset)
            <div class="bg-slate-900/50 rounded-xl p-4 flex items-center justify-between">
                <span class="text-sm text-slate-300">{{ $asset }}</span>
                <button class="text-indigo-400 text-sm flex items-center gap-1 hover:text-indigo-300 transition">
                    <i class="bi bi-download"></i> Download
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <div class="glass rounded-2xl p-6">
        <h2 class="font-semibold text-lg mb-3">Key Facts</h2>
        <ul class="space-y-2 text-sm text-slate-400">
            <li class="flex gap-2"><i class="bi bi-dot text-indigo-400 text-lg"></i> Founded: 2023</li>
            <li class="flex gap-2"><i class="bi bi-dot text-indigo-400 text-lg"></i> Headquarters: Nairobi, Kenya</li>
            <li class="flex gap-2"><i class="bi bi-dot text-indigo-400 text-lg"></i> Team size: 12 full-time employees</li>
            <li class="flex gap-2"><i class="bi bi-dot text-indigo-400 text-lg"></i> Certifications: SOC 2 Type II, ISO 27001, GDPR Compliant</li>
        </ul>
    </div>

    <div class="glass rounded-2xl p-6">
        <h2 class="font-semibold text-lg mb-3">Media Contact</h2>
        <p class="text-slate-400 text-sm">For press inquiries, interview requests, or media partnerships:</p>
        <p class="text-white mt-2 font-medium">press@votesecure.io</p>
    </div>
</div>
@endsection
