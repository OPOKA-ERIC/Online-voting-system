@extends('layouts.static')
@section('title', 'Contact')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Get in Touch</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">We'd love to <span class="gradient-text">hear from you</span></h1>
<p class="text-slate-400 text-lg mb-12">Whether you have a question, want a demo, or need support — we're here.</p>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Contact Form -->
    <div class="glass rounded-2xl p-8">
        <h2 class="font-semibold text-lg mb-6">Send a message</h2>
        <form class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-400 mb-1">Full Name</label>
                <input type="text" placeholder="Your name"
                    class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Email</label>
                <input type="email" placeholder="you@example.com"
                    class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Subject</label>
                <select class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 transition">
                    <option>General Inquiry</option>
                    <option>Book a Demo</option>
                    <option>Technical Support</option>
                    <option>Sales / Pricing</option>
                    <option>Press / Media</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Message</label>
                <textarea rows="5" placeholder="Tell us how we can help..."
                    class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition resize-none"></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-500 to-violet-600 rounded-xl font-semibold hover:brightness-110 transition">
                Send Message
            </button>
        </form>
    </div>

    <!-- Contact Info -->
    <div class="space-y-5">
        @foreach([
            ['bi-envelope', 'Email', 'hello@votesecure.io', 'General inquiries'],
            ['bi-headset', 'Support', 'support@votesecure.io', 'Technical help'],
            ['bi-briefcase', 'Sales', 'sales@votesecure.io', 'Pricing & demos'],
            ['bi-newspaper', 'Press', 'press@votesecure.io', 'Media inquiries'],
        ] as [$icon, $label, $email, $desc])
        <div class="glass rounded-2xl p-5 flex items-center gap-4">
            <div class="w-11 h-11 bg-indigo-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="bi {{ $icon }} text-indigo-400 text-lg"></i>
            </div>
            <div>
                <div class="font-medium text-white text-sm">{{ $label }}</div>
                <div class="text-indigo-400 text-sm">{{ $email }}</div>
                <div class="text-slate-500 text-xs">{{ $desc }}</div>
            </div>
        </div>
        @endforeach

        <div class="glass rounded-2xl p-5">
            <div class="font-medium text-white text-sm mb-1">Response Time</div>
            <p class="text-slate-400 text-sm">We typically respond within <span class="text-white">2 business hours</span> during weekdays.</p>
        </div>
    </div>
</div>
@endsection
