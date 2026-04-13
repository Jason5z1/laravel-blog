<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>This is my article</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .btn { transition: none !important; }
    </style>


</head>
<body>
 <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Blog</h1>
        <div>
@auth
            <span class="me-3 text-muted">Welcome, {{ Auth::user()->name }}!</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary me-2">Logout</button>
            </form>
@else
            <a href="/login" class="btn btn-outline-primary me-2">Login</a>
            <a href="/register" class="btn btn-outline-success">Register</a>
@endauth
        </div>
    </div>

    @yield('content')
 </div>

<script src="{{ asset('js/posts.js') }}"></script>
  
</body>
</html>
