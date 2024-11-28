@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Task: {{ $task->title }}</h2>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Assigned By:</strong> {{ $task->assignedBy?->name }}</p>
        <p><strong>Assigned To:</strong> {{ $task->assignedTo?->name }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        <p><strong>Status:</strong> {{ $task->status }}</p>

        <hr>

        <h4>Comments</h4>
        @forelse ($task->comments as $comment)
            <div class="mb-3">
                <strong>{{ $comment->user->name }}</strong> <span
                    class="text-muted">({{ $comment->created_at->diffForHumans() }})</span>
                <p>{{ $comment->content }}</p>
            </div>
        @empty
            <p>No comments yet.</p>
        @endforelse

        <hr>

        <h4>Add a Comment</h4>
        <form method="POST" action="{{ route('comments.store', $task) }}">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..."></textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </div>
        </form>
    </div>
@endsection
