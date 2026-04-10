@extends('layout.app')
@section('content')
<a href="/posts/create" class="btn btn-primary mb-3">Create new article</a>
<h2>Login/Register in navbar (welcome.blade.php) or <a href="/login">Login</a> | <a href="/register">Register</a></h2>
@if(auth()->check())
<p>Welcome {{ auth()->user()->name }}! <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></p>
<form id="logout-form" method="POST" action="/logout" style="display:none">@csrf</form>
@endif
@foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $post->title }}</h5>
            <p>{{ Str::limit($post->content, 100) }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-info btn-sm">View</a>
            @if(auth()->check())
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
            <form method="POST" action="/posts/{{ $post->id }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
            </form>
            @endif
        </div>
    </div>
@endforeach
@endsection
