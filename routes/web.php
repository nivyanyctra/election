<?php

use App\Http\Controllers\VotingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [VotingController::class, 'index'])->name('voting.index');
Route::post('/vote', [VotingController::class, 'storeVote']);
Route::get('/quick-count', function () {
    return view('quick_count');
});
Route::get('/api/stats', [VotingController::class, 'getRealtimeStats']);
Route::get('/api/admin/logs', [AdminController::class, 'getRealtimeLogs']);

// Admin
Route::redirect('/himatif', '/himatif/admin/dashboard');
Route::redirect('/admin', '/himatif/admin/dashboard');
Route::prefix('himatif/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::get('/candidates', [AdminController::class, 'candidateIndex'])->name('candidates');
    Route::post('/candidates', [AdminController::class, 'candidateStore'])->name('candidates.store');
    Route::delete('/candidates/{candidate}', [AdminController::class, 'candidateDelete'])->name('candidates.delete');
});
