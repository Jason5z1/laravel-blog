@extends('layout.app')
@section('content')
<a href="/posts/create" class="btn btn-primary mb-3">Create new article</a>
@if($posts->count() > 0)
@foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-info btn-sm">View</a>
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
            <form method="POST" action="/posts/{{ $post->id }}" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>
@endforeach
@else
<div class="alert alert-info">
    No posts yet. <a href="/posts/create">Create one!</a>
</div>
@endif
@endsection
