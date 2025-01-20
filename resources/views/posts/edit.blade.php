@extends('layouts.app')

@push('styles')
    @vite('resources/css/editPost.css')
@endpush

@section('content')
    <h1>Edit Post</h1>

    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
        </div>
        <div>
            <label for="content">Content</label>
            <textarea name="content" required>{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="form-group">
            <label for="image_url">Post Picture:</label>
            <div class="image">
                @if($post->image_url)
                    <img src="{{ asset('storage/'.$post->image_url) }}" alt="PostPicture" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <p>No post picture available. Upload a new picture.</p>
                @endif
            </div>
            <input type="file" name="image_url">
            @error('profile_picture') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
@endsection
