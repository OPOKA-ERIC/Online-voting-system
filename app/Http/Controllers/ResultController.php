<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show($id)
    {
        $election = Election::with('candidates.votes')->findOrFail($id);
        $totalVotes = $election->votes()->count();

        // Gate check: only show results if voter has voted or election is closed
        $hasVoted = Vote::where('user_id', auth()->id())->where('election_id', $id)->exists();
        $isClosed = now() > $election->end_date;

        if (!$hasVoted && !$isClosed) {
            return redirect()->route('voter.dashboard')
                ->with('error', 'Results are available after you vote or the election closes.');
        }

        $results = $election->candidates->map(function ($c) use ($totalVotes) {
            return [
                'name'       => $c->name,
                'photo'      => $c->photo,
                'votes'      => $c->votes->count(),
                'percentage' => $totalVotes > 0
                    ? round($c->votes->count() / $totalVotes * 100, 1) : 0,
            ];
        })->sortByDesc('votes')->values();

        return view('voter.results', compact('election', 'results', 'totalVotes'));
    }
}
