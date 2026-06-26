<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();
        return view('voting', compact('candidates'));
    }

    public function storeVote(Request $request)
    {
        $request->validate(['candidate_id' => 'required|exists:candidates,id']);

        $ipAddress = $request->ip();
        $sessionKey = 'last_vote_time_' . str_replace('.', '_', $ipAddress);

        if (session()->has($sessionKey) && (time() - session($sessionKey) < 10)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tunggu sebentar sebelum pemilih berikutnya.'
            ], 429);
        }

        Vote::create(['candidate_id' => $request->candidate_id]);

        session([$sessionKey => time()]);

        return response()->json(['status' => 'success']);
    }

    public function getRealtimeStats()
    {
        $vote = Vote::all();
        $total = $vote->count();
        $results = Candidate::withCount('votes')->get()->map(function ($c) use ($total) {
            return [
                'name' => $c->name,
                'votes' => $c->votes_count,
                'percent' => $total > 0 ? round(($c->votes_count / $total) * 100, 1) : 0
            ];
        });
        return response()->json(['total' => $total, 'results' => $results]);
    }
}
