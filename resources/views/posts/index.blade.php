@extends('layout.app')
@section('content')

<div class="row">

    {{-- 🟦 左边 --}}
    <div class="col-md-8">

        @auth
        <a href="/posts/create" class="btn btn-primary mb-3">Create new article</a>
        @endauth

        @if($posts->count() > 0)
            @foreach ($posts as $post)
                @php
                    $userReaction = null;
                    if(auth()->check()) {
                        $like = $post->likes()->where('user_id', auth()->id())->first();
                        $userReaction = $like ? $like->pivot->type : null;
                    }
                @endphp 

                <div id="post-{{ $post->id }}" class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $post->title }}</h5>
                        <p>By: {{ $post->user->name }}</p>

                        <p>{{ Str::limit($post->content, 100) }}</p>

                        <a href="/posts/{{ $post->id }}" class="btn btn-info btn-sm">View</a>

                        <button onclick="react({{ $post->id }},'like',this)"
class="like-btn btn btn-sm {{ $userReaction === 'like' ? 'btn-primary' : 'btn-outline-primary' }}">
                            👍 <span class="like-count">
                                {{ $post->likes->where('pivot.type', 'like')->count() }}
                            </span>
                            <span class="like-popup">+1</span>
                        </button>

                        <button onclick="react({{ $post->id }},'dislike',this)"
                            class="btn btn-sm {{ $userReaction === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }}">
                            👎 <span class="dislike-count">
                                {{ $post->likes->where('pivot.type', 'dislike')->count() }}
                            </span>
                        </button>

                        @auth
                            @if(auth()->id() === $post->user_id)
                                <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                                <form method="POST" action="/posts/{{ $post->id }}" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <div class="alert alert-info">
                No posts yet.
            </div>
        @endif

    </div>

    {{-- 🟨 右边 --}}
    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                🔥 Popular Posts
            </div>

            <ul class="list-group list-group-flush">
                @foreach($popularPosts as $index => $p)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>
                            {{ $index + 1 }}.
                            <a href="/posts/{{ $p->id }}">{{ $p->title }}</a>
                        </span>
                        <span class="badge bg-primary">
                            👍 {{ $p->likes_count }}
                        </span>
                    </li>
                @endforeach
            </ul>

        </div>

    </div>

</div>

@endsection