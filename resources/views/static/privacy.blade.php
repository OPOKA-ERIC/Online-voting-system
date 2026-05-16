@extends('layouts.static')
@section('title', 'Privacy Policy')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Legal</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-2">Privacy Policy</h1>
<p class="text-slate-500 text-sm mb-10">Last updated: May 1, 2025</p>

<div class="space-y-8 text-slate-400 text-sm leading-relaxed">
    @foreach([
        ['Information We Collect', 'We collect information you provide directly to us, such as your name, email address, voter ID, and any other information you choose to provide when registering or using our platform. We also collect usage data such as IP addresses, browser type, and pages visited to improve our services.'],
        ['How We Use Your Information', 'We use the information we collect to verify your identity, process your vote, send you election reminders and receipts, provide customer support, and improve our platform. We do not sell your personal information to third parties.'],
        ['Vote Anonymity', 'Your vote is cryptographically separated from your identity after submission. While we verify that you are eligible to vote, the content of your ballot is stored anonymously and cannot be linked back to you by any party, including VoteSecure staff.'],
        ['Data Retention', 'We retain your account information for as long as your account is active. Election audit data is retained for 7 years to comply with legal requirements. You may request deletion of your personal data at any time by contacting us.'],
        ['Security', 'We implement industry-standard security measures including end-to-end encryption, two-factor authentication, and regular third-party security audits. We are SOC 2 Type II certified and GDPR compliant.'],
        ['Your Rights', 'You have the right to access, correct, or delete your personal data. You may also request a copy of your data or object to its processing. To exercise these rights, contact us at privacy@votesecure.io.'],
        ['Contact Us', 'If you have questions about this Privacy Policy, please contact our Data Protection Officer at privacy@votesecure.io.'],
    ] as [$heading, $body])
    <div>
        <h2 class="text-white font-semibold text-base mb-2">{{ $heading }}</h2>
        <p>{{ $body }}</p>
    </div>
    @endforeach
</div>
@endsection
