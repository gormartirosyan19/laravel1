<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $posts = $query->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $this->postService->createPost($validated, $request);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validated();
        $this->postService->updatePost($post, $validated, $request);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $this->postService->deletePost($post);

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
