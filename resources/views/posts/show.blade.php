@extends('layout.app')
@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <h3>Comments ({{ $post->comments->count() }})</h3>
        @foreach($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->content }}</p>
            </div>
        </div>
        @endforeach
        
        @if(auth()->check())
        <form method="POST" action="/posts/{{ $post->id }}/comments" class="mt-4">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" placeholder="Add comment..." required></textarea>
            </div>
            <button class="btn btn-primary">Post Comment</button>
        </form>
        @endif
        <a href="/" class="btn btn-secondary mt-3">← Back</a>
    </div>
</div>
@endsection
