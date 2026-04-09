@extends('layout.app')
@section('content')

<a href="/posts/create" class="btn btn-primary mb-3">Create new article</a>
@foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->content }}</p>
            <h6>Comments:</h6>
            @foreach ($post->comments as $comment)
                <p>{{ $comment->content }}</p>
            @endforeach
            <form method="POST" action="/posts/{{ $post->id }}/comments">
                @csrf
                <input type="text" name="content" class="form-control mb-2" placeholder="Add a comment">
                <button class = "btn btn-primary btn-sm">Submit Comment</button>
            </form>
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning">Edit</a>
            <form method="POST" action="/posts/{{ $post->id }}" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
@endforeach
@endsection