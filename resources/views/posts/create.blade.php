@extends('layouts.app')

@section('title', 'Create Post')

@push('styles')
    @vite(['resources/css/createPost.css'])
@endpush

@section('content')
    <h1>Create a New Post</h1>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" required>
        </div>

        <div>
            <label for="content">Content</label>
            <textarea name="content" required></textarea>
        </div>

        <div>
            <label for="image_url">Upload Image</label>
            <input type="file" name="image_url" accept="image/*">
        </div>

        <button type="submit">Create Post</button>
    </form>
@endsection
