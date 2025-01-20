@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
    @vite(['resources/css/profile.css'])
@endpush

@section('content')
    <div class="profile">
        <div class="user-info">
            <div class="image">
                @if($user->profile_picture)
                    <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture">
                @else
                    <p>No profile picture available. Click edit to add a picture</p>
                @endif
            </div>
            <input type="file" name="profile_picture" id="profile_picture" style="display: none;">
          <div>
              <p><strong>Name:</strong> {{ $user->name }}</p>
              <p><strong>Email:</strong> {{ $user->email ?? 'Not Available' }}</p>
              <p><strong>Joined On:</strong> {{ $user->created_at->format('M d, Y') }}</p>
          </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fa-solid fa-pen" style="color: #37321f;"></i>Edit Profile</a>
    </div>
    <div class="user-posts-links">
        <ul>
            @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
                <li><a href="{{ route('posts.create') }}" class="btn">Create a new post</a></li>
                <li><a href="{{ route('posts.index', ['user_id' => Auth::id()]) }}" class="filter-btn">My posts</a></li>
                <li><a href="{{ route('products.create')}}" class="filter-btn">Add a new product</a></li>
                <li><a href="{{ route('products.index', ['user_id' => Auth::id()])}}" class="filter-btn">My products</a></li>
            @endif
            <li><a href="{{ route('orders.index')}}" class="filter-btn">Purchases</a></li>
            <li><a href="{{ route('address.index')}}" class="filter-btn">Addresses</a></li>
        </ul>

    </div>
@endsection
