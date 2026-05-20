<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show($id)
    {
        $election = Election::with(['positions.candidates.votes', 'candidates.votes'])->findOrFail($id);
        $totalVotes = $election->votes()->count();

        // Only show results after the election has ended
        if (now() <= $election->end_date) {
            $hasVoted = Vote::where('user_id', auth()->id())->where('election_id', $id)->exists();
            $message = $hasVoted
                ? 'You have already voted. Please wait for the results when the election closes.'
                : 'Results will be available once the election ends.';
            return redirect()->route('voter.dashboard')->with('error', $message);
        }

        // Voter's own votes: position_id => candidate_id
        $myVotes = Vote::where('user_id', auth()->id())
            ->where('election_id', $id)
            ->pluck('candidate_id', 'position_id')
            ->toArray();

        // Results grouped by position
        $resultsByPosition = $election->positions->map(function ($position) use ($myVotes) {
            $positionTotal = $position->candidates->sum(fn($c) => $c->votes->count());
            $candidates = $position->candidates->map(function ($c) use ($positionTotal, $myVotes, $position) {
                return [
                    'id'         => $c->id,
                    'name'       => $c->name,
                    'photo'      => $c->photo,
                    'votes'      => $c->votes->count(),
                    'percentage' => $positionTotal > 0 ? round($c->votes->count() / $positionTotal * 100, 1) : 0,
                    'is_my_vote' => isset($myVotes[$position->id]) && $myVotes[$position->id] == $c->id,
                ];
            })->sortByDesc('votes')->values();

            return [
                'position'   => $position->name,
                'total'      => $positionTotal,
                'candidates' => $candidates,
            ];
        });

        return view('voter.results', compact('election', 'resultsByPosition', 'totalVotes', 'myVotes'));
    }
}
