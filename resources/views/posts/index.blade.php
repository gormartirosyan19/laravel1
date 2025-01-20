@extends('layouts.app')

@push('styles')
    @vite('resources/css/allPosts.css')
@endpush

@section('content')
    @if (session('success'))
        <div id="success-alert" style="
        position: fixed;
        top: 20px;
        right: -300px;
        background-color: #d4edda;
        color: green;
        border: 1px solid green;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        transition: right 0.5s ease-in-out;">
            {{ session('success') }}
        </div>
    @endif


    <h1>All Posts</h1>
    @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
        <a href="{{ route('posts.create') }}" class="create-btn">Create New Post</a>
    @endif


    <ul class="posts-list">
        @forelse ($posts as $post)
            <li class="post-item">
                <a href="{{ route('posts.show', $post->id) }}">
                    <div class="post-content">
                        <div class="image">
                            @if($post->image_url)
                                <img src="{{ asset('storage/'.$post->image_url) }}" alt="Profile Picture">
                            @else
                                <p>No post picture available</p>
                            @endif
                        </div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ Str::limit($post->content, 100) }}</p>
                        <small>Posted on {{ $post->created_at->format('M d, Y H:i') }}</small>
                    </div>
                </a>
                <div class="post-actions">
                    @if ($post->user_id == Auth::id() || Auth::user()->hasRole('admin'))
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this post?')">Delete
                            </button>
                        </form>
                    @endif
                </div>
            </li>
        @empty
            <p>No posts available.</p>
        @endforelse
    </ul>
@endsection
