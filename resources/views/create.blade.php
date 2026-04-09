@extends('layout.app') 
@section('content')

<h2>Create new article</h2>
<form method="POST" action="/posts">
    @csrf
    <div class="mb-3">
        <label>Title: </label>
        <input type="text" name="title" class="form-control">
    </div>
    <div class="mb-3">
        <label>Content: </label>
        <textarea name="content" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Submit</button>
</form>

@endsection
