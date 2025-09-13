<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Question;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::with('creator', 'questions')->latest()->get();
        return view('interviews.index', compact('interviews'));
    }

    public function create()
    {
        return view('interviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string'
        ]);

        $interview = Interview::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'created_by' => auth()->id()
        ]);

        foreach ($validated['questions'] as $index => $questionText) {
            Question::create([
                'interview_id' => $interview->id,
                'question_text' => $questionText,
                'order' => $index + 1
            ]);
        }

        return redirect()->route('interviews.show', $interview)
            ->with('success', 'Interview created successfully!');
    }

    public function show(Interview $interview)
    {
        $interview->load('questions', 'submissions.candidate', 'submissions.reviews');
        return view('interviews.show', compact('interview'));
    }
}