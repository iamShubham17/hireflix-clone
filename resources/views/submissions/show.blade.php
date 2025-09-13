@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Submission for {{ $submission->interview->title }}</div>
            <div class="card-body">
                <h5>Candidate: {{ $submission->candidate->name }}</h5>
                <p>Status: {{ ucfirst($submission->status) }}</p>
                <p>Submitted: {{ $submission->created_at->format('M d, Y H:i') }}</p>

                <h6>Answers</h6>
                @foreach ($submission->answers as $answer)
                    <div class="mb-3">
                        <p><strong>Question {{ $answer->question->order }}:</strong> {{ $answer->question->question_text }}</p>
                        @if ($answer->video_path)
                            <video controls class="w-100" style="max-height: 300px;">
                                <source src="{{ asset('storage/' . $answer->video_path) }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <p>No video uploaded.</p>
                        @endif
                    </div>
                @endforeach

                <h6>Add Review</h6>
                <form method="POST" action="{{ route('reviews.store', $submission) }}">
                    @csrf
                    <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                    <div class="mb-3">
                        <label class="form-label">Score (1-10)</label>
                        <input type="number" name="score" class="form-control" min="1" max="10" required>
                        @error('score') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comments</label>
                        <textarea name="comments" class="form-control" rows="4" required></textarea>
                        @error('comments') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>

                @if ($submission->reviews->isNotEmpty())
                    <h6 class="mt-4">Existing Reviews</h6>
                    @foreach ($submission->reviews as $review)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p><strong>Score:</strong> {{ $review->score }}/10</p>
                                <p><strong>Comments:</strong> {{ $review->comments }}</p>
                                <p><small>By: {{ $review->reviewer->name }} on {{ $review->created_at->format('M d, Y H:i') }}</small></p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection