@extends('layouts.app')

@section('title', 'Edit Profile')

@push('styles')
    @vite('resources/css/edit-profile.css')
@endpush

@section('content')
    <div class="profile-edit">
        <h1>Edit Your Profile</h1>

        @if(session('status') == 'profile-updated')
            <div class="alert alert-success">Profile updated successfully!</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <div class="image">
                    @if($user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <p>No profile picture available. Upload a new picture.</p>
                    @endif
                </div>
                <input type="file" name="profile_picture">
                @error('profile_picture') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

{{--            <div class="form-group">--}}
{{--                <label for="email">Email:</label>--}}
{{--                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>--}}
{{--                @error('email') <span class="text-danger">{{ $message }}</span> @enderror--}}
{{--            </div>--}}



            <button type="submit">Save Changes</button>
        </form>
    </div>
@endsection
