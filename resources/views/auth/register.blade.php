@extends('layouts.app')

@section('title', 'Register')

@push('styles')
    @vite(['resources/css/register.css'])
@endpush

@section('content')
<form class="register-form-container" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control" required>

    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    @error('password')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <button type="submit" class="btn btn-primary">Register</button>
</form>
@endsection
