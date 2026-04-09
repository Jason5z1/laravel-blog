@extends('layout.app')
@section('content')

<h2>Edit article</h2>
<form method="POST" action="/posts/{{ $post->id }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Title: </label>
        <input type="text" name="title" class="form-control" value="{{ $post->title }}">
    </div>
    <div class="mb-3">
        <label>Content: </label>
        <textarea name="content" class="form-control">{{ $post->content }}</textarea>
    </div>
    <button class="btn btn-success">Submit</button>
</form>
@endsection