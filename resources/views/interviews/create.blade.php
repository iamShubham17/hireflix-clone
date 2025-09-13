@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Create Interview</div>
            <div class="card-body">
                <form method="POST" action="{{ route('interviews.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Questions</label>
                        <div id="questions-container">
                            <div class="input-group mb-2">
                                <input type="text" name="questions[]" class="form-control" placeholder="Enter question" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="removeQuestion(this)">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addQuestion()">Add Question</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Interview</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function addQuestion() {
        const container = document.getElementById('questions-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = '<input type="text" name="questions[]" class="form-control" placeholder="Enter question" required> <button type="button" class="btn btn-outline-secondary" onclick="removeQuestion(this)">Remove</button>';
        container.appendChild(div);
    }
    function removeQuestion(button) {
        button.parentElement.remove();
    }
</script>
@endsection