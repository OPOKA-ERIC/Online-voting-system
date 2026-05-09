<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

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
            'positions'   => 'nullable|array',
            'positions.*' => 'nullable|string|max:255',
        ]);

        $election = Election::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
        ]);

        if (!empty($validated['positions'])) {
            foreach (array_filter($validated['positions']) as $positionName) {
                Position::create(['election_id' => $election->id, 'name' => $positionName]);
            }
        }

        return redirect()->route('admin.elections.index')->with('success', 'Election created successfully.');
    }

    public function show(Election $election)
    {
        $election->load(['candidates.votes', 'votes', 'positions']);
        $voters = $election->voters()->with('votes')->get();

        // Parse uploaded file to get all original columns
        $fileHeaders = [];
        $fileRows    = collect();

        if ($election->voters_file && Storage::disk('public')->exists($election->voters_file)) {
            $fullPath  = Storage::disk('public')->path($election->voters_file);
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            if (in_array($extension, ['xlsx', 'xls'])) {
                $parsed = Excel::toCollection(new class implements ToCollection, WithHeadingRow {
                    public function collection(Collection $rows) {}
                }, $fullPath)->first();
                if ($parsed && $parsed->isNotEmpty()) {
                    $fileHeaders = array_keys($parsed->first()->toArray());
                    $fileRows    = $parsed;
                }
            } else {
                $content = file($fullPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $parsed  = array_map('str_getcsv', $content);
                $fileHeaders = array_map('trim', array_shift($parsed));
                $fileRows = collect($parsed)->map(function ($row) use ($fileHeaders) {
                    if (count($row) !== count($fileHeaders)) return null;
                    return collect(array_combine($fileHeaders, array_map('trim', $row)));
                })->filter()->values();
            }
        }

        return view('admin.elections.show', compact('election', 'voters', 'fileHeaders', 'fileRows'));
    }

    public function edit(Election $election)
    {
        $election->load('positions');
        return view('admin.elections.edit', compact('election'));
    }

    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'position_names' => 'nullable|array',
            'position_names.*'=> 'nullable|string|max:255',
            'position_ids'   => 'nullable|array',
        ]);

        $election->update($request->only('title', 'description', 'start_date', 'end_date'));

        // Sync positions
        $ids   = $request->input('position_ids', []);
        $names = $request->input('position_names', []);

        $keptIds = [];
        foreach ($names as $index => $name) {
            if (empty(trim($name))) continue;
            $positionId = $ids[$index] ?? null;
            if ($positionId) {
                // Update existing
                Position::where('id', $positionId)->update(['name' => trim($name)]);
                $keptIds[] = $positionId;
            } else {
                // Create new
                $p = Position::create(['election_id' => $election->id, 'name' => trim($name)]);
                $keptIds[] = $p->id;
            }
        }

        // Delete removed positions
        $election->positions()->whereNotIn('id', $keptIds)->delete();

        return redirect()->route('admin.elections.index')->with('success', 'Election updated successfully.');
    }

    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->route('admin.elections.index')->with('success', 'Election deleted successfully.');
    }
}
