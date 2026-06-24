<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logs()
    {
        $logs = Vote::with('candidate')->latest()->paginate(20);
        return view('admin.logs', compact('logs'));
    }

    public function getRealtimeLogs()
    {
        // Mengambil 20 vote terbaru
        $logs = Vote::with('candidate')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'candidate_name' => $log->candidate->name,
                    // Format: Senin, 24 Juni 2026 - 15:30:45
                    'formatted_time' => $log->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY - HH:mm:ss'),
                    'time_ago' => $log->created_at->diffForHumans()
                ];
            });

        return response()->json($logs);
    }

    public function candidateIndex()
    {
        $candidates = Candidate::all();
        return view('admin.candidates', compact('candidates'));
    }

    public function candidateStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'photo' => 'required|image|max:2048'
        ]);
        $data['photo'] = $request->file('photo')->store('candidates', 'public');
        Candidate::create($data);
        return back()->with('success', 'Calon berhasil ditambah');
    }

    public function candidateDelete(Candidate $candidate)
    {
        $candidate = Candidate::get('id');
        Storage::disk('public')->delete($candidate->photo);
        $candidate->delete();
        return back();
    }
}
