@extends('layouts.app')

@push('styles')
    @vite('resources/css/allPosts.css')
@endpush

@section('content')
    <h1>All Posts</h1>

    <a href="{{ route('posts.create') }}" class="create-btn">Create New Post</a>

    <ul class="posts-list">
        @forelse ($posts as $post)
{{--            <div href="{{ route('posts.show', $post->id) }}">--}}
                <li class="post-item">
                    <a href="{{ route('posts.show', $post->id) }}">
                    <div class="post-content">
                        <div class="image">
                            @if($post->image_url)
                                <img src="{{ asset($post->image_url) }}" alt="Profile Picture">
                            @else
                                <p>No post picture available</p>
                            @endif
                        </div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ Str::limit($post->content, 100) }}</p>
                        <small>Posted by: {{ $post->user->name }}
                            on {{ $post->created_at->format('M d, Y H:i') }}</small>
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
{{--            </div>--}}
        @empty
            <p>No posts available.</p>
        @endforelse
    </ul>
@endsection
