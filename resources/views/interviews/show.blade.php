@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>{{ $interview->title }}</h2>
        <p>{{ $interview->description }}</p>

        <div class="card mb-4">
            <div class="card-header">Questions</div>
            <div class="card-body">
                <ol>
                    @foreach($interview->questions as $question)
                        <li>{{ $question->question_text }}</li>
                    @endforeach
                </ol>
            </div>
        </div>

        @if(Auth::user()->role !== 'candidate')
        <div class="card">
            <div class="card-header">Submissions</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Candidate</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th>Reviews</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interview->submissions as $submission)
                        <tr>
                            <td>{{ $submission->candidate->name }}</td>
                            <td>{{ ucfirst($submission->status) }}</td>
                            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $submission->reviews->count() }}</td>
                            <td>
                                <a href="{{ route('submissions.show', $submission) }}" class="btn btn-sm btn-info">Review</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection