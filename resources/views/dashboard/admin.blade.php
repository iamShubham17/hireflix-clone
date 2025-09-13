@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard - {{ ucfirst(Auth::user()->role) }}</h2>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('interviews.create') }}" class="btn btn-primary">Create Interview</a>
            @endif
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Interviews</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Questions</th>
                            <th>Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interviews as $interview)
                        <tr>
                            <td>{{ $interview->title }}</td>
                            <td>{{ $interview->questions->count() }}</td>
                            <td>{{ $interview->submissions->count() }}</td>
                            <td>
                                <a href="{{ route('interviews.show', $interview) }}" class="btn btn-sm btn-info">View</a>
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