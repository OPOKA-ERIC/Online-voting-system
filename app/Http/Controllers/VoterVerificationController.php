<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoterVerificationController extends Controller
{
    public function show($electionId)
    {
        $election = Election::findOrFail($electionId);

        if ($election->status !== 'active') {
            return redirect()->route('voter.dashboard')
                ->with('error', 'This election is not currently active.');
        }

        // If no voter list uploaded, allow any logged-in voter but still enforce one-vote
        $uniqueColumn = $election->unique_column ?? null;
        $hasVoterList = $election->voters_data && $uniqueColumn;

        // Check if already voted in this election
        $hasVoted = Vote::where('user_id', auth()->id())
                        ->where('election_id', $electionId)
                        ->exists();

        if ($hasVoted) {
            return redirect()->route('voter.results', $electionId)
                ->with('error', 'You have already voted in this election.');
        }

        return view('voter.verify', compact('election', 'uniqueColumn', 'hasVoterList'));
    }

    public function verify(Request $request, $electionId)
    {
        $election = Election::findOrFail($electionId);

        // Block if already voted — hard stop
        $hasVoted = Vote::where('user_id', auth()->id())
                        ->where('election_id', $electionId)
                        ->exists();

        if ($hasVoted) {
            return redirect()->route('voter.results', $electionId)
                ->with('error', 'You have already voted in this election.');
        }

        $hasVoterList = $election->voters_data && $election->unique_column;

        if ($hasVoterList) {
            $request->validate(['unique_value' => 'required|string']);

            $uniqueColumn = $election->unique_column;
            $votersData   = collect($election->voters_data);
            $inputValue   = strtolower(trim($request->unique_value));

            // Find matching row by unique column value
            $voterRow = $votersData->first(function ($row) use ($uniqueColumn, $inputValue) {
                $row = (array) $row;
                $val = $row[$uniqueColumn] ?? '';
                if (is_array($val)) $val = implode(' ', $val);
                return strtolower(trim((string) $val)) === $inputValue;
            });

            if (!$voterRow) {
                return back()->with('error',
                    'Your ' . strtoupper(str_replace('_', ' ', $uniqueColumn)) .
                    ' was not found in the registered voters list for this election.');
            }

            $voterRow = (array) $voterRow;

            // Find name column dynamically
            $nameKeys = ['name', 'names', 'full name', 'full names', 'fullname', 'full_name',
                         'student name', 'voter name', 'group a', 'group b'];
            $registeredName = '';
            foreach ($nameKeys as $nk) {
                if (!empty($voterRow[$nk])) {
                    $registeredName = strtolower(trim($voterRow[$nk]));
                    break;
                }
            }

            // Check logged-in user name matches registered name
            $loggedInName = strtolower(trim(auth()->user()->name));

            if ($registeredName && $loggedInName !== $registeredName) {
                return back()->with('error',
                    'Your account name "' . auth()->user()->name .
                    '" does not match the name registered for this ' .
                    strtoupper(str_replace('_', ' ', $uniqueColumn)) .
                    '. Please contact the administrator.');
            }

            // Store the verified unique value in session to prevent session sharing
            session([
                'verified_election_' . $electionId        => true,
                'verified_unique_val_' . $electionId       => $inputValue,
            ]);

        } else {
            // No voter list — just mark as verified (one-vote still enforced by DB)
            session(['verified_election_' . $electionId => true]);
        }

        return redirect()->route('voter.vote', $electionId);
    }
}
