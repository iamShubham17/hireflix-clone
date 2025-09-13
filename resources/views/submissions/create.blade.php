@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h2>{{ $interview->title }}</h2>
        <p>{{ $interview->description }}</p>

        <form method="POST" action="{{ route('submissions.store', $interview) }}" enctype="multipart/form-data">
            @csrf
            
            @foreach($interview->questions as $index => $question)
            <div class="card mb-4">
                <div class="card-header">
                    Question {{ $index + 1 }}
                </div>
                <div class="card-body">
                    <p class="mb-3">{{ $question->question_text }}</p>
                    
                    <div class="video-container mb-3">
                        <video id="video-{{ $question->id }}" class="video-preview" controls></video>
                    </div>
                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary record-btn" onclick="startRecording({{ $question->id }})">Start Recording</button>
                        <button type="button" class="btn btn-danger record-btn" onclick="stopRecording({{ $question->id }})" disabled>Stop Recording</button>
                    </div>
                    
                    <input type="file" name="videos[{{ $question->id }}]" id="file-{{ $question->id }}" class="form-control mt-3" accept="video/*">
                </div>
            </div>
            @endforeach

            <button type="submit" class="btn btn-success btn-lg">Submit Interview</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let mediaRecorders = {};
let recordedChunks = {};

async function startRecording(questionId) {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        const video = document.getElementById(`video-${questionId}`);
        video.srcObject = stream;
        video.play();
        
        const mediaRecorder = new MediaRecorder(stream);
        mediaRecorders[questionId] = mediaRecorder;
        recordedChunks[questionId] = [];
        
        mediaRecorder.ondataavailable = event => {
            if (event.data.size > 0) {
                recordedChunks[questionId].push(event.data);
            }
        };
        
        mediaRecorder.onstop = () => {
            const blob = new Blob(recordedChunks[questionId], { type: 'video/webm' });
            const file = new File([blob], `recording-${questionId}.webm`, { type: 'video/webm' });
            
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById(`file-${questionId}`).files = dataTransfer.files;
            
            video.srcObject = null;
            video.src = URL.createObjectURL(blob);
        };
        
        mediaRecorder.start();
        
        // Update buttons
        event.target.disabled = true;
        event.target.nextElementSibling.disabled = false;
    } catch (err) {
        console.error('Error accessing media devices:', err);
        alert('Please allow camera and microphone access to record videos.');
    }
}

function stopRecording(questionId) {
    if (mediaRecorders[questionId]) {
        mediaRecorders[questionId].stop();
        mediaRecorders[questionId].stream.getTracks().forEach(track => track.stop());
        
        // Update buttons
        event.target.disabled = true;
        event.target.previousElementSibling.disabled = false;
    }
}
</script>
@endpush
@endsection