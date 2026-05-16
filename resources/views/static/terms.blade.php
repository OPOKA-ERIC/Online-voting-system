@extends('layouts.static')
@section('title', 'Terms of Service')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Legal</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-2">Terms of Service</h1>
<p class="text-slate-500 text-sm mb-10">Last updated: May 1, 2025</p>

<div class="space-y-8 text-slate-400 text-sm leading-relaxed">
    @foreach([
        ['Acceptance of Terms', 'By accessing or using VoteSecure, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our platform.'],
        ['Eligibility', 'You must be eligible to vote in the specific election you are participating in. Attempting to vote in an election for which you are not eligible is strictly prohibited and may result in legal consequences.'],
        ['Account Responsibilities', 'You are responsible for maintaining the confidentiality of your account credentials. You agree to notify us immediately of any unauthorized use of your account. You may not share your account with others.'],
        ['Prohibited Conduct', 'You may not attempt to manipulate, tamper with, or interfere with any election. You may not cast more than one vote per election. You may not use automated tools or bots to interact with the platform.'],
        ['Intellectual Property', 'All content, features, and functionality of VoteSecure are owned by VoteSecure, Inc. and are protected by copyright, trademark, and other intellectual property laws.'],
        ['Limitation of Liability', 'VoteSecure shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the platform, to the maximum extent permitted by applicable law.'],
        ['Termination', 'We reserve the right to suspend or terminate your account at any time for violation of these terms or for any other reason at our sole discretion.'],
        ['Changes to Terms', 'We may update these Terms of Service from time to time. We will notify you of significant changes via email or a prominent notice on our platform.'],
        ['Contact', 'For questions about these Terms, contact us at legal@votesecure.io.'],
    ] as [$heading, $body])
    <div>
        <h2 class="text-white font-semibold text-base mb-2">{{ $heading }}</h2>
        <p>{{ $body }}</p>
    </div>
    @endforeach
</div>
@endsection
