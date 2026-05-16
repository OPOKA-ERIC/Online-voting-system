@extends('layouts.static')
@section('title', 'Pricing')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Pricing</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">Simple, transparent <span class="gradient-text">pricing</span></h1>
<p class="text-slate-400 text-lg mb-12">No hidden fees. Start free, scale as you grow.</p>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Free -->
    <div class="glass rounded-2xl p-8 flex flex-col">
        <h3 class="font-semibold text-xl mb-1">Free</h3>
        <div class="text-4xl font-bold my-4">$0<span class="text-slate-400 text-base font-normal">/mo</span></div>
        <p class="text-slate-400 text-sm mb-6">Perfect for small organizations and student councils.</p>
        <ul class="space-y-3 text-sm text-slate-300 flex-1">
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Up to 500 voters</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> 3 elections/month</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Basic analytics</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Email support</li>
        </ul>
        <a href="{{ route('register') }}" class="mt-8 block text-center py-3 border border-white/20 rounded-2xl hover:bg-white/10 transition text-sm font-medium">Get Started</a>
    </div>

    <!-- Pro -->
    <div class="rounded-2xl p-8 flex flex-col bg-gradient-to-b from-indigo-600/40 to-violet-600/20 border border-indigo-500/40 relative">
        <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-indigo-500 text-white text-xs font-semibold px-4 py-1 rounded-full">Most Popular</span>
        <h3 class="font-semibold text-xl mb-1">Pro</h3>
        <div class="text-4xl font-bold my-4">$29<span class="text-slate-400 text-base font-normal">/mo</span></div>
        <p class="text-slate-400 text-sm mb-6">For growing organizations that need more power.</p>
        <ul class="space-y-3 text-sm text-slate-300 flex-1">
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Up to 10,000 voters</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Unlimited elections</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Real-time analytics</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Priority support</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Custom branding</li>
        </ul>
        <a href="{{ route('register') }}" class="mt-8 block text-center py-3 bg-indigo-500 hover:bg-indigo-600 rounded-2xl transition text-sm font-semibold">Start Free Trial</a>
    </div>

    <!-- Enterprise -->
    <div class="glass rounded-2xl p-8 flex flex-col">
        <h3 class="font-semibold text-xl mb-1">Enterprise</h3>
        <div class="text-4xl font-bold my-4">Custom</div>
        <p class="text-slate-400 text-sm mb-6">For large institutions and national-scale elections.</p>
        <ul class="space-y-3 text-sm text-slate-300 flex-1">
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Unlimited voters</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> Dedicated infrastructure</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> SLA guarantee</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> 24/7 dedicated support</li>
            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-emerald-400"></i> On-premise option</li>
        </ul>
        <a href="{{ route('contact') }}" class="mt-8 block text-center py-3 border border-white/20 rounded-2xl hover:bg-white/10 transition text-sm font-medium">Contact Sales</a>
    </div>
</div>
@endsection
