@extends('layouts.static')
@section('title', 'Cookie Policy')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Legal</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-2">Cookie Policy</h1>
<p class="text-slate-500 text-sm mb-10">Last updated: May 1, 2025</p>

<div class="space-y-8 text-slate-400 text-sm leading-relaxed">
    @foreach([
        ['What Are Cookies', 'Cookies are small text files stored on your device when you visit a website. They help us remember your preferences, keep you logged in, and understand how you use our platform.'],
        ['Cookies We Use', null],
        ['How to Control Cookies', 'You can control and delete cookies through your browser settings. Note that disabling certain cookies may affect the functionality of VoteSecure, including your ability to stay logged in.'],
        ['Third-Party Cookies', 'We do not use third-party advertising cookies. We may use analytics cookies from trusted providers to understand platform usage. These providers are contractually bound to keep your data confidential.'],
        ['Updates to This Policy', 'We may update this Cookie Policy from time to time. Continued use of VoteSecure after changes constitutes acceptance of the updated policy.'],
        ['Contact', 'For questions about our use of cookies, contact us at privacy@votesecure.io.'],
    ] as [$heading, $body])
    <div>
        <h2 class="text-white font-semibold text-base mb-2">{{ $heading }}</h2>
        @if($body)
            <p>{{ $body }}</p>
        @else
            <div class="space-y-3">
                @foreach([
                    ['Essential Cookies', 'Required for the platform to function. These include session cookies that keep you logged in.', 'Always Active'],
                    ['Analytics Cookies', 'Help us understand how visitors interact with our platform so we can improve it.', 'Optional'],
                    ['Preference Cookies', 'Remember your settings such as language and display preferences.', 'Optional'],
                ] as [$name, $desc, $status])
                <div class="glass rounded-xl p-4 flex items-start justify-between gap-4">
                    <div>
                        <div class="text-white font-medium text-sm mb-1">{{ $name }}</div>
                        <p class="text-xs">{{ $desc }}</p>
                    </div>
                    <span class="flex-shrink-0 text-xs px-3 py-1 rounded-full
                        {{ $status === 'Always Active' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-700 text-slate-400' }}">
                        {{ $status }}
                    </span>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
