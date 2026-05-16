<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        $elections = Election::with(['positions', 'candidates'])
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        $userId = auth()->id();

        // Per-election: how many positions the voter has voted in
        $voteProgress = [];
        foreach ($elections as $election) {
            $totalPositions = $election->positions->count();
            $votedPositions = Vote::where('user_id', $userId)
                ->where('election_id', $election->id)
                ->distinct('position_id')
                ->count('position_id');
            $voteProgress[$election->id] = [
                'voted'  => $votedPositions,
                'total'  => $totalPositions,
                'done'   => $totalPositions > 0 && $votedPositions >= $totalPositions,
            ];
        }

        return view('voter.dashboard', compact('elections', 'voteProgress'));
    }

    public function show($id)
    {
        $election = Election::with(['positions.candidates'])->findOrFail($id);
        $hasVoted = Vote::where('user_id', auth()->id())->where('election_id', $id)->exists();

        // Enforce verification unless already voted
        if (!session('verified_election_' . $id) && !$hasVoted) {
            return redirect()->route('voter.verify', $id)
                ->with('error', 'Please verify your identity before voting.');
        }

        $votedPositionIds = Vote::where('user_id', auth()->id())
            ->where('election_id', $id)
            ->pluck('position_id')
            ->toArray();
        return view('voter.candidates', compact('election', 'hasVoted', 'votedPositionIds'));
    }

    public function store(Request $request)
    {
        $election = Election::findOrFail($request->election_id);

        // Hard stop: election must be active
        if (now() < $election->start_date || now() > $election->end_date) {
            return back()->with('error', 'This election is not currently active.');
        }

        // Hard stop: must be verified
        if (!session('verified_election_' . $election->id)) {
            return redirect()->route('voter.verify', $election->id)
                ->with('error', 'Please verify your identity before voting.');
        }

        // Hard stop: one vote per position per election per user
        $alreadyVoted = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->where('position_id', $request->position_id)
            ->exists();

        if ($alreadyVoted) {
            return back()->with('error', 'You have already voted for this position. Each voter can only vote once per position.');
        }

        $vote = Vote::create([
            'user_id'      => auth()->id(),
            'election_id'  => $election->id,
            'candidate_id' => $request->candidate_id,
            'position_id'  => $request->position_id,
        ]);

        // Check if all positions are now voted
        $totalPositions = $election->positions()->count();
        $votedPositions = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->distinct('position_id')
            ->count('position_id');

        if ($votedPositions >= $totalPositions) {
            // Build full receipt from DB
            $allVotes = Vote::with(['candidate', 'position'])
                ->where('user_id', auth()->id())
                ->where('election_id', $election->id)
                ->get()
                ->map(fn($v) => [
                    'position'  => $v->position->name,
                    'candidate' => $v->candidate->name,
                    'voted_at'  => $v->created_at->format('M d, Y h:i A'),
                ])->toArray();

            session([
                'election_id'    => $election->id,
                'election_title' => $election->title,
                'all_votes'      => $allVotes,
                'voted_at'       => now()->format('M d, Y h:i A'),
            ]);

            return redirect()->route('voter.confirmation');
        }

        return redirect()->route('voter.vote', $election->id)
            ->with('success', 'Vote cast! Continue voting for the remaining positions.');
    }

    public function confirmation()
    {
        return view('voter.confirmation');
    }
}
