@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Candidate Dashboard</h2>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Available Interviews</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Questions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interviews as $interview)
                        <tr>
                            <td>{{ $interview->title }}</td>
                            <td>{{ Str::limit($interview->description, 50) }}</td>
                            <td>{{ $interview->questions->count() }}</td>
                            <td>
                                <a href="{{ route('submissions.create', $interview) }}" class="btn btn-sm btn-primary">Start Interview</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>My Submissions</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Interview</th>
                            <th>Status</th>
                            <th>Reviews</th>
                            <th>Average Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr>
                            <td>{{ $submission->interview->title }}</td>
                            <td>{{ ucfirst($submission->status) }}</td>
                            <td>{{ $submission->reviews->count() }}</td>
                            <td>
                                @if($submission->reviews->count() > 0)
                                    {{ round($submission->reviews->avg('score'), 1) }}/10
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection