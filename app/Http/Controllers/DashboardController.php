<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'candidate') {
            $interviews = Interview::where('status', 'active')->latest()->get();
            $submissions = Submission::where('candidate_id', $user->id)
                ->with('interview', 'reviews')
                ->latest()
                ->get();
            
            return view('dashboard.candidate', compact('interviews', 'submissions'));
        }
        
        $interviews = Interview::where('created_by', $user->id)
            ->orWhere(function($query) use ($user) {
                if ($user->role === 'reviewer') {
                    $query->where('status', 'active');
                }
            })
            ->with('submissions')
            ->latest()
            ->get();
        
        return view('dashboard.admin', compact('interviews'));
    }
}