<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:10',
            'comments' => 'required|string'
        ]);

        Review::updateOrCreate(
            [
                'submission_id' => $submission->id,
                'reviewer_id' => auth()->id()
            ],
            $validated
        );

        return back()->with('success', 'Review submitted successfully!');
    }
}