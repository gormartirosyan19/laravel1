@extends('layouts.app')

@section('title', 'Welcome Page')

@push('styles')
    @vite(['resources/css/welcome.css'])
@endpush

@section('content')
    <div class="posts-container">
        @foreach($posts as $post)
            <div class="post-card">
                <a href="{{ route('posts.show', $post->id) }}">
                <div class="image">
                    <img src="{{ $post->image_url }}" alt="Post Image" class="post-image">
                </div>
                <div class="post-content">
                    <h2 class="post-title">{{ $post->title }}</h2>
                    <p>{{ Str::limit($post->content, 100) }}</p>
                    <p class="post-excerpt">{{ Str::limit($post->excerpt, 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="read-more-btn">Read More</a>
                </div>
                </a>
            </div>

        @endforeach
    </div>
@endsection
