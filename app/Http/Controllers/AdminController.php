<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'elections'  => Election::count(),
            'candidates' => Candidate::count(),
            'voters'     => User::where('role', 'voter')->count(),
            'votes'      => Vote::count(),
        ];

        return view('admin.dashboard', $data);
    }
}
