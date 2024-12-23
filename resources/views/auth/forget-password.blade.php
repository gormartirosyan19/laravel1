@extends('layouts.app')

@section('title', 'Forgot Password')

@push('styles')
    @vite(['resources/css/forget.css'])
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('forget-password.request') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
@endsection
