<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
});

Route::middleware(['auth', 'voter'])->prefix('voter')->name('voter.')->group(function () {
    Route::get('/', [VoteController::class, 'index'])->name('dashboard');
    Route::get('/election/{id}', [VoteController::class, 'show'])->name('vote');
    Route::post('/vote', [VoteController::class, 'store'])->name('cast');
    Route::get('/confirmation', [VoteController::class, 'confirmation'])->name('confirmation');
    Route::get('/results/{id}', [ResultController::class, 'show'])->name('results');
});

require __DIR__.'/auth.php';
