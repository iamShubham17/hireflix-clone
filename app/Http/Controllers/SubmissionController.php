<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Submission;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function create(Interview $interview)
    {
        $submission = Submission::firstOrCreate([
            'interview_id' => $interview->id,
            'candidate_id' => auth()->id()
        ]);

        return view('submissions.create', compact('interview', 'submission'));
    }

    public function store(Request $request, Interview $interview)
    {
        $submission = Submission::where([
            'interview_id' => $interview->id,
            'candidate_id' => auth()->id()
        ])->firstOrFail();

        foreach ($request->file('videos', []) as $questionId => $video) {
            if ($video) {
                $path = $video->store('videos', 'public');
                
                Answer::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'question_id' => $questionId
                    ],
                    [
                        'video_path' => $path
                    ]
                );
            }
        }

        $submission->update(['status' => 'completed']);

        return redirect()->route('dashboard')
            ->with('success', 'Submission completed successfully!');
    }

    public function show(Submission $submission)
    {
        $submission->load('interview.questions', 'answers', 'reviews.reviewer');
        return view('submissions.show', compact('submission'));
    }
}