<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index()
    {
        return view('admin.elections.index', ['elections' => Election::all()]);
    }

    public function create()
    {
        return view('admin.elections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ]);

        Election::create($validated);

        return redirect()->route('admin.elections.index')->with('success', 'Election created successfully.');
    }

    public function show(Election $election)
    {
        $election->load(['candidates.votes']);
        return view('admin.elections.show', compact('election'));
    }

    public function edit(Election $election)
    {
        return view('admin.elections.edit', compact('election'));
    }

    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ]);

        $election->update($request->only('title', 'description', 'start_date', 'end_date'));

        return redirect()->route('admin.elections.index')->with('success', 'Election updated successfully.');
    }

    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->route('admin.elections.index')->with('success', 'Election deleted successfully.');
    }
}
