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
        $election = Election::findOrFail($id);
        $candidates = $election->candidates;
        $hasVoted = Vote::where('user_id', auth()->id())->where('election_id', $id)->exists();

        return view('voter.candidates', compact('election', 'candidates', 'hasVoted'));
    }

    public function store(Request $request)
    {
        $election = Election::findOrFail($request->election_id);

        // Rule 1: Active period check
        if (now() < $election->start_date || now() > $election->end_date) {
            return back()->with('error', 'This election is not currently active.');
        }

        // Rule 2: Double vote check
        $alreadyVoted = Vote::where('user_id', auth()->id())->where('election_id', $election->id)->exists();
        if ($alreadyVoted) {
            return back()->with('error', 'You have already voted in this election.');
        }

        // Save the vote
        $vote = Vote::create([
            'user_id'      => auth()->id(),
            'election_id'  => $election->id,
            'candidate_id' => $request->candidate_id,
        ]);

        return redirect()->route('voter.confirmation')->with([
            'election_title'   => $election->title,
            'candidate_name'   => $vote->candidate->name,
            'voted_at'         => now()->format('Y-m-d H:i:s'),
            'election_id'      => $election->id,
        ]);
    public function confirmation()
    {
        return view('voter.confirmation');
    }
}
