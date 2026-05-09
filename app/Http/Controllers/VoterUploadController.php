<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class VoterUploadController extends Controller
{
    public function create()
    {
        return view('admin.voters.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'voters_file' => 'required|file|mimes:csv,txt,xlsx,xls,pdf,doc,docx|max:5120',
            'election_id' => 'nullable|exists:elections,id',
        ]);

        $electionId = $request->election_id;
        $file       = $request->file('voters_file');
        $extension  = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['pdf', 'doc', 'docx'])) {
            return back()->with('error', 'PDF and Word documents cannot be parsed. Please upload a CSV or Excel (.xlsx) file with columns: name, email, password.');
        }

        // Store the file linked to the election
        $path = $file->store('voters_files', 'public');
        if ($electionId) {
            Election::where('id', $electionId)->update(['voters_file' => $path]);
        }

        // Parse rows
        if (in_array($extension, ['xlsx', 'xls'])) {
            $rows = Excel::toCollection(new class implements ToCollection, WithHeadingRow {
                public function collection(Collection $rows) {}
            }, $file)->first();
        } else {
            $content = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $parsed  = array_map('str_getcsv', $content);
            $header  = array_map('trim', array_shift($parsed));
            $rows    = collect($parsed)->map(function ($row) use ($header) {
                if (count($row) !== count($header)) return null;
                return collect(array_combine($header, array_map('trim', $row)));
            })->filter();
        }

        $imported = 0;
        $skipped  = 0;

        foreach ($rows as $row) {
            $email = trim($row['email'] ?? '');
            $name  = trim($row['name'] ?? '');
            if (empty($email) || empty($name)) continue;

            $existing = User::where('email', $email)->first();
            if ($existing) {
                $existing->update(['election_id' => $electionId]);
                $skipped++;
            } else {
                User::create([
                    'name'        => $name,
                    'email'       => $email,
                    'password'    => Hash::make(trim($row['password'] ?? 'password')),
                    'role'        => 'voter',
                    'election_id' => $electionId,
                ]);
                $imported++;
            }
        }

        if ($electionId) {
            return redirect()->route('admin.elections.show', $electionId)
                ->with('success', "$imported new voter(s) imported. $skipped existing voter(s) linked to this election.");
        }

        return back()->with('success', "$imported voter(s) imported. $skipped existing voter(s) updated.");
    }
}
