<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        Post::create($request->all());
        return redirect('/');
    }

    public function show($id)
    {
        $post = Post::with('comments.user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('/');
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect('/');
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate(['content' => 'required|string|max:1000']);
        
        $userId = auth()->id();
        \Log::info('User ID for comment', ['user_id' => $userId]);
        
        Comment::create([
            'content' => $request->content,
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
        
        return redirect("/posts/{$postId}")->with('success', 'Comment added!');
    }
}

