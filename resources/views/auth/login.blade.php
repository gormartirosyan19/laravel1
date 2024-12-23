@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    @vite(['resources/css/login.css'])
@endpush

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert').style.display = 'none';
            }, 2000);
        </script>

    @endif

    <form class="login-form-container" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="form-group remember">
            <label for="remember">
                <input type="checkbox" name="remember">
                Remember Me
            </label>
        </div>
        <div class="mt-3">
            <a href="{{ route('forget-password.request') }}">Forgot your password?</a>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
@endsection
