<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('election', 'position')->latest()->get();
        return view('admin.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $elections = Election::with('positions')->get();
        return view('admin.candidates.create', compact('elections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'election_id' => 'required|exists:elections,id',
            'position_id' => 'nullable|exists:positions,id',
            'name'        => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'photo'       => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($validated);

        return redirect()->route('admin.candidates.index')->with('success', 'Candidate created successfully.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load('election', 'position', 'votes');
        return view('admin.candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $elections = Election::with('positions')->get();
        return view('admin.candidates.edit', compact('candidate', 'elections'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'election_id' => 'required|exists:elections,id',
            'position_id' => 'nullable|exists:positions,id',
            'name'        => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'photo'       => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($validated);

        return redirect()->route('admin.candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('admin.candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
