@extends('layouts.static')
@section('title', 'Careers')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Join Us</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Help us build the future of <span class="gradient-text">democracy</span></h1>
<p class="text-slate-400 text-lg mb-12">We're a small, passionate team working on technology that matters. Remote-first, mission-driven.</p>

<div class="space-y-4 mb-12">
    @foreach([
        ['Senior Backend Engineer', 'Remote', 'Full-time', 'Laravel, PHP, PostgreSQL'],
        ['Frontend Engineer', 'Remote', 'Full-time', 'Vue.js, Tailwind CSS, TypeScript'],
        ['Security Engineer', 'Remote', 'Full-time', 'Cryptography, Penetration Testing'],
        ['Product Designer', 'Remote', 'Full-time', 'Figma, UX Research, Accessibility'],
        ['DevOps Engineer', 'Remote', 'Contract', 'AWS, Docker, Kubernetes'],
    ] as [$role, $location, $type, $stack])
    <div class="glass rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-semibold text-lg text-white">{{ $role }}</h3>
            <div class="flex items-center gap-3 mt-1 text-sm text-slate-400">
                <span><i class="bi bi-geo-alt mr-1"></i>{{ $location }}</span>
                <span>•</span>
                <span>{{ $type }}</span>
                <span>•</span>
                <span class="text-slate-500">{{ $stack }}</span>
            </div>
        </div>
        <a href="{{ route('contact') }}" class="flex-shrink-0 px-5 py-2.5 bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 rounded-xl text-sm font-medium hover:bg-indigo-500/30 transition">
            Apply Now
        </a>
    </div>
    @endforeach
</div>

<div class="glass rounded-2xl p-8 text-center">
    <h2 class="heading-font text-2xl font-semibold mb-3">Don't see your role?</h2>
    <p class="text-slate-400 mb-6">We're always looking for talented people. Send us your CV and tell us how you'd contribute.</p>
    <a href="{{ route('contact') }}" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 rounded-2xl font-semibold hover:brightness-110 transition">
        Get in Touch
    </a>
</div>
@endsection
