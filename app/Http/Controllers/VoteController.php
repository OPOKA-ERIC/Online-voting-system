<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {

        $elections = Election::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('voter.dashboard', compact('elections'));
    }

    public function show($id)
    {
        $election = Election::with(['positions.candidates'])->findOrFail($id);
        $hasVoted = Vote::where('user_id', auth()->id())->where('election_id', $id)->exists();
        $votedPositionIds = Vote::where('user_id', auth()->id())
            ->where('election_id', $id)
            ->pluck('position_id')
            ->toArray();
        return view('voter.candidates', compact('election', 'hasVoted', 'votedPositionIds'));
    }

    public function store(Request $request)
    {
        $election = Election::findOrFail($request->election_id);

        if (now() < $election->start_date || now() > $election->end_date) {
            return back()->with('error', 'This election is not currently active.');
        }

        // Check if already voted for this position
        $alreadyVoted = Vote::where('user_id', auth()->id())
            ->where('election_id', $election->id)
            ->where('position_id', $request->position_id)
            ->exists();

        if ($alreadyVoted) {
            return back()->with('error', 'You have already voted for this position.');
        }

        $vote = Vote::create([
            'user_id'      => auth()->id(),
            'election_id'  => $election->id,
            'candidate_id' => $request->candidate_id,
            'position_id'  => $request->position_id,
        ]);

        return redirect()->route('voter.vote', $election->id)->with('success', 'Your vote has been cast successfully!');
    }

    public function confirmation()
    {
        return view('voter.confirmation');
    }
}
