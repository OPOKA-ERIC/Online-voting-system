<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterUploadController;

use App\Http\Controllers\VoterVerificationController;

Route::get('/', function () {
    // Live stats from DB
    $stats = [
        'elections' => \App\Models\Election::count(),
        'voters'    => \App\Models\User::where('role', 'voter')->count(),
        'votes'     => \App\Models\Vote::count(),
        'positions' => \App\Models\Position::count(),
    ];

    // Hero demo card: most recent CLOSED election, or fallback to demo
    $heroElection = \App\Models\Election::with(['positions.candidates'])
        ->where('end_date', '<', now())
        ->latest()->first();

    // Only show chart data for CLOSED elections — never reveal live/ongoing results
    $chartElection = \App\Models\Election::with(['candidates' => function ($q) {
        $q->withCount('votes');
    }])->whereHas('votes')->where('end_date', '<', now())->latest()->first();

    $chartData = null;
    if ($chartElection) {
        $total = $chartElection->votes()->count();
        $chartData = [
            'title'      => $chartElection->title,
            'status'     => $chartElection->status,
            'total'      => $total,
            'candidates' => $chartElection->candidates->sortByDesc('votes_count')->values()->map(fn($c) => [
                'name'       => $c->name,
                'votes'      => $c->votes_count,
                'percentage' => $total > 0 ? round($c->votes_count / $total * 100, 1) : 0,
            ])->toArray(),
        ];
    }

    $testimonials = \App\Models\Testimonial::where('is_active', true)->get();
    $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort_order')->get();

    return view('welcome', compact('chartData', 'stats', 'testimonials', 'faqs', 'heroElection'));
})->name('home');

// Static footer pages
Route::get('/features',  fn() => view('static.features'))->name('features');
Route::get('/elections', fn() => view('static.elections'))->name('elections');
Route::get('/pricing',   fn() => view('static.pricing'))->name('pricing');
Route::get('/changelog', fn() => view('static.changelog'))->name('changelog');
Route::get('/roadmap',   fn() => view('static.roadmap'))->name('roadmap');
Route::get('/api-docs',  fn() => view('static.api-docs'))->name('api-docs');
Route::get('/about',     fn() => view('static.about'))->name('about');
Route::get('/blog',      fn() => view('static.blog'))->name('blog');
Route::get('/careers',   fn() => view('static.careers'))->name('careers');
Route::get('/press',     fn() => view('static.press'))->name('press');
Route::get('/contact',   fn() => view('static.contact'))->name('contact');
Route::get('/privacy',   fn() => view('static.privacy'))->name('privacy');
Route::get('/terms',     fn() => view('static.terms'))->name('terms');
Route::get('/security',  fn() => view('static.security'))->name('security');
Route::get('/cookies',   fn() => view('static.cookies'))->name('cookies');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('voter.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('elections', ElectionController::class);
    Route::resource('candidates', CandidateController::class);
    Route::get('/voters/upload', [VoterUploadController::class, 'create'])->name('voters.upload');
    Route::post('/voters/upload', [VoterUploadController::class, 'store'])->name('voters.upload.store');
});

Route::middleware(['auth', 'voter'])->prefix('voter')->name('voter.')->group(function () {
    Route::get('/', [VoteController::class, 'index'])->name('dashboard');
    Route::get('/verify/{election}', [VoterVerificationController::class, 'show'])->name('verify');
    Route::post('/verify/{election}', [VoterVerificationController::class, 'verify'])->name('verify.submit');
    Route::get('/election/{id}', [VoteController::class, 'show'])->name('vote');
    Route::post('/vote', [VoteController::class, 'store'])->name('cast');
    Route::get('/confirmation', [VoteController::class, 'confirmation'])->name('confirmation');
    Route::get('/results/{id}', [ResultController::class, 'show'])->name('results');
});

require __DIR__.'/auth.php';
