@extends('layouts.app')

@section('title', $post->title)
@push('styles')
    @vite('resources/css/postDetails.css')
@endpush

@section('content')
    <div class="post-details">
        <h1>{{ $post->title }}</h1>
        <div class="image">
            <img src="{{ asset($post->image_url) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 400px; margin-bottom: 20px;">
        </div>
        <p>{{ $post->content }}</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Back to Home</a>
    </div>
@endsection
