@extends('layouts.static')
@section('title', 'API Docs')
@section('content')
<span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Developers</span>
<h1 class="heading-font text-5xl font-bold mt-3 mb-4">API <span class="gradient-text">Documentation</span></h1>
<p class="text-slate-400 text-lg mb-12">Integrate VoteSecure into your own systems with our RESTful API.</p>

<div class="glass rounded-2xl p-6 mb-6">
    <h2 class="font-semibold text-lg mb-2">Base URL</h2>
    <code class="block bg-slate-900 text-emerald-400 rounded-xl px-4 py-3 text-sm font-mono">https://api.votesecure.io/v1</code>
</div>

<div class="space-y-6">
    @foreach([
        ['GET', '/elections', 'List all elections', 'Returns a paginated list of all active elections.'],
        ['GET', '/elections/{id}', 'Get election details', 'Returns full details for a specific election including candidates and positions.'],
        ['POST', '/elections/{id}/vote', 'Cast a vote', 'Submit a ballot for the authenticated voter. Requires Bearer token.'],
        ['GET', '/elections/{id}/results', 'Get results', 'Returns live or final results for an election.'],
        ['GET', '/voters/me', 'Get current voter', 'Returns the authenticated voter profile and eligibility status.'],
    ] as [$method, $endpoint, $title, $desc])
    <div class="glass rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-3">
            <span class="px-3 py-1 rounded-lg text-xs font-bold font-mono
                {{ $method === 'GET' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-indigo-500/20 text-indigo-400' }}">
                {{ $method }}
            </span>
            <code class="text-slate-300 text-sm font-mono">{{ $endpoint }}</code>
        </div>
        <div class="font-medium mb-1">{{ $title }}</div>
        <p class="text-slate-400 text-sm">{{ $desc }}</p>
    </div>
    @endforeach
</div>

<div class="mt-10 glass rounded-2xl p-6">
    <h2 class="font-semibold text-lg mb-3">Authentication</h2>
    <p class="text-slate-400 text-sm mb-4">All API requests require a Bearer token in the Authorization header.</p>
    <code class="block bg-slate-900 text-emerald-400 rounded-xl px-4 py-3 text-sm font-mono">Authorization: Bearer &lt;your_api_token&gt;</code>
</div>
@endsection
