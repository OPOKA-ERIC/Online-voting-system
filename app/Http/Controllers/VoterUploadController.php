<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;

class VoterUploadController extends Controller
{
    public function create()
    {
        $elections = Election::all();
        return view('admin.voters.upload', compact('elections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'voters_file' => 'required|file|max:10240',
            'election_id' => 'required|exists:elections,id',
        ]);

        $electionId = $request->election_id;
        $file       = $request->file('voters_file');
        $extension  = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['csv', 'txt', 'xlsx', 'xls'])) {
            return back()->with('error', 'Invalid file type. Please upload CSV or Excel.');
        }

        // ── PARSE ──
        $rawRows = [];

        if (in_array($extension, ['xlsx', 'xls'])) {

            $allSheets = Excel::toArray(new class implements ToArray {
                public function array(array $array): void {}
            }, $file);

            foreach ($allSheets as $sheet) {
                if (empty($sheet)) continue;

                // Find first row with 2+ filled cells = header
                $headerIndex = null;
                foreach ($sheet as $i => $row) {
                    if (count(array_filter($row, fn($v) => trim((string)$v) !== '')) >= 2) {
                        $headerIndex = $i;
                        break;
                    }
                }
                if ($headerIndex === null) continue;

                // Map index => clean column name (skip empty headers)
                $colMap = [];
                foreach (array_values($sheet[$headerIndex]) as $idx => $h) {
                    $key = strtolower(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/u', '', (string)$h)));
                    if ($key !== '') $colMap[$idx] = $key;
                }
                if (empty($colMap)) continue;

                // Build data rows
                for ($i = $headerIndex + 1; $i < count($sheet); $i++) {
                    $row    = array_values($sheet[$i]);
                    $record = [];
                    foreach ($colMap as $idx => $key) {
                        $record[$key] = trim((string)($row[$idx] ?? ''));
                    }
                    if (!empty(array_filter($record))) $rawRows[] = $record;
                }
                break;
            }

        } else {

            $content = preg_replace('/^\xEF\xBB\xBF/', '', file_get_contents($file->getRealPath()));
            $lines   = array_values(array_filter(explode("\n", str_replace("\r", "", $content))));

            if (empty($lines)) return back()->with('error', 'The file is empty.');

            $header = array_map(fn($h) => strtolower(trim($h)), str_getcsv(array_shift($lines)));

            foreach ($lines as $line) {
                $values = str_getcsv($line);
                if (count($values) < count($header)) continue;
                $record = array_combine($header, array_slice(array_map('trim', $values), 0, count($header)));
                if (!empty(array_filter($record))) $rawRows[] = $record;
            }
        }

        if (empty($rawRows)) {
            return back()->with('error', 'The uploaded file is empty or could not be parsed.');
        }

        // ── NORMALIZE ──
        $rows = collect($rawRows)->map(function ($row) {
            $clean = [];
            foreach ((array)$row as $key => $value) {
                $k = strtolower(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/u', '', (string)$key)));
                $v = trim((string)(is_array($value) ? implode(' ', $value) : $value));
                if ($k !== '') $clean[$k] = $v;
            }
            return $clean;
        })->filter(fn($row) => collect($row)->filter(fn($v) => $v !== '')->isNotEmpty())->values();

        if ($rows->isEmpty()) {
            return back()->with('error', 'No valid rows found in the file.');
        }

        $columns   = array_keys($rows->first());
        $totalRows = $rows->count();

        // ── STRIP SPARSE ROWS (footer/summary) ──
        $totalCols = count($columns);
        $rows = $rows->filter(function ($row) use ($totalCols) {
            return collect($row)->filter(fn($v) => $v !== '')->count() >= ceil($totalCols * 0.5);
        })->values();

        $totalRows = $rows->count();

        // ── DETECT UNIQUE COLUMN ──
        // Pick the column with the most unique values (highest uniqueness ratio)
        // Skip name-like columns in first pass
        $nameColumns  = ['name', 'names', 'full name', 'full names', 'fullname', 'full_name', 'student name', 'voter name'];
        $uniqueColumn = null;
        $bestCount    = 0;

        // First pass: non-name columns
        foreach ($columns as $col) {
            if (in_array($col, $nameColumns)) continue;
            $vals  = $rows->map(fn($r) => strtolower(trim((string)($r[$col] ?? ''))))->filter();
            $count = $vals->unique()->count();
            if ($count > $bestCount) {
                $bestCount    = $count;
                $uniqueColumn = $col;
            }
        }

        // Second pass: include name columns if nothing better found
        if (!$uniqueColumn) {
            foreach ($columns as $col) {
                $vals  = $rows->map(fn($r) => strtolower(trim((string)($r[$col] ?? ''))))->filter();
                $count = $vals->unique()->count();
                if ($count > $bestCount) {
                    $bestCount    = $count;
                    $uniqueColumn = $col;
                }
            }
        }

        if (!$uniqueColumn) {
            return back()->with('error', 'Could not detect any identifier column in the file.');
        }

        // ── SAVE ──
        $path = $file->store('voters_files', 'public');
        Election::where('id', $electionId)->update([
            'voters_file'   => $path,
            'unique_column' => $uniqueColumn,
            'voters_data'   => json_encode($rows->toArray()),
        ]);

        // ── DETECT NAME COLUMN ──
        $nameCol = null;
        foreach ($nameColumns as $nc) {
            if (in_array($nc, $columns)) { $nameCol = $nc; break; }
        }
        if (!$nameCol) {
            foreach ($columns as $col) {
                if ($col !== $uniqueColumn) { $nameCol = $col; break; }
            }
        }

        // ── IMPORT USERS ──
        $imported = 0; $skipped = 0;
        foreach ($rows as $row) {
            $name  = $nameCol ? trim($row[$nameCol] ?? '') : '';
            $email = trim($row['email address'] ?? $row['email'] ?? '');
            if (empty($name)) continue;
            $existing = $email ? User::where('email', $email)->first() : null;
            if ($existing) {
                $existing->update(['election_id' => $electionId]);
                $skipped++;
            } elseif ($email) {
                User::create([
                    'name'        => $name,
                    'email'       => $email,
                    'password'    => Hash::make($row['password'] ?? 'password'),
                    'role'        => 'voter',
                    'election_id' => $electionId,
                ]);
                $imported++;
            }
        }

        $label = strtoupper(str_replace('_', ' ', $uniqueColumn));
        return redirect()->route('admin.elections.index')
            ->with('success', "✓ Uploaded. Unique identifier: \"$label\". Voters enter their $label to verify. $imported imported, $skipped updated.");
    }
}
