@extends('layouts.static')
@section('title', 'Blog')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Insights</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">The VoteSecure <span class="gradient-text">Blog</span></h1>
<p class="text-slate-400 text-lg mb-12">Thoughts on democracy, election technology, and security.</p>

<div class="space-y-6">
    @foreach([
        ['How Zero-Knowledge Proofs Are Changing Online Voting', 'May 10, 2025', 'Security', 'We explore how ZK proofs allow voters to prove eligibility without revealing their identity — and why this matters for the future of digital democracy.'],
        ['5 Lessons from Running 100+ Online Elections', 'April 22, 2025', 'Case Study', 'After powering over 100 elections across universities and organizations, here are the most important things we\'ve learned about voter behavior and system design.'],
        ['Why Blockchain Alone Isn\'t Enough for Secure Voting', 'March 15, 2025', 'Technology', 'Blockchain is a powerful tool, but it\'s not a silver bullet. We break down what it does well — and where you still need traditional security layers.'],
        ['Designing for Accessibility in Voting Interfaces', 'February 8, 2025', 'Design', 'Every voter deserves a seamless experience. Here\'s how we approach accessibility-first design in our ballot UI.'],
    ] as [$title, $date, $tag, $excerpt])
    <article class="glass rounded-2xl p-6 hover:border-indigo-500/30 transition-colors cursor-pointer">
        <div class="flex items-center gap-3 mb-3">
            <span class="text-xs font-semibold px-3 py-1 bg-indigo-500/20 text-indigo-400 rounded-full">{{ $tag }}</span>
            <span class="text-slate-500 text-xs">{{ $date }}</span>
        </div>
        <h2 class="font-semibold text-lg mb-2 text-white">{{ $title }}</h2>
        <p class="text-slate-400 text-sm leading-relaxed">{{ $excerpt }}</p>
        <div class="mt-4 text-indigo-400 text-sm flex items-center gap-1 hover:gap-2 transition-all">
            Read more <i class="bi bi-arrow-right"></i>
        </div>
    </article>
    @endforeach
</div>
@endsection
