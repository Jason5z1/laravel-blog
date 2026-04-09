<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts',compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect('/');
    }

    public function store(Request $request)
    {
        Post::create($request->all());
        return redirect('/');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return redirect('/');
    }

    public function storeComment(Request $request, $postId)
    {
        $post = Post::find($postId);
        $post->comments()->create($request->all());
        return redirect('/');
    }
}
