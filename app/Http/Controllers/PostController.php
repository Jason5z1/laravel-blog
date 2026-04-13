<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(5);
        $popularPosts = Post::withCount(['likes as likes_count' => function($query) {
            $query->where('type', 'like');
        }])->orderBy('likes_count', 'desc')->take(5)->get();
        return view('posts.index', compact('posts', 'popularPosts'));
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
        
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);
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
        if(auth()->id() !== $post->user_id) {
            abort(403);
        }
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $post = Post::findOrFail($id);
        if(auth()->id() !== $post->user_id) {
            abort(403);
        }
        $post->update($request->all());
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if(auth()->id() !== $post->user_id) {
            abort(403);
        }
        $post->delete();
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

    public function react(Request $request, $postId, $type)
    {
        $post = Post::findOrFail($postId);
        $userId = auth()->id();

        $existing = DB::table('likes')->where('post_id', $postId)->where('user_id', $userId)->first();
        
        if($existing) {
            if($existing->type === $type) {
                DB::table('likes')->where('id', $existing->id)->delete();
            } else {
                DB::table('likes')->where('id', $existing->id)->update(['type' => $type]);
            }
        } else {
            DB::table('likes')->insert([
                'user_id' => $userId,
                'post_id' => $postId,
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $likes = DB::table('likes')->where('post_id', $postId)->where('type', 'like')->count();
        $dislikes = DB::table('likes')->where('post_id', $postId)->where('type', 'dislike')->count();
        
        // Recalculate user reaction after update
        $currentReaction = null;
        $userReaction = DB::table('likes')
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();
        if ($userReaction) {
            $currentReaction = $userReaction->type;
        }
        
        return response()->json([
            'likes' => $likes,
            'dislikes' => $dislikes,
            'userReaction' => $currentReaction
        ]);
    }
}

