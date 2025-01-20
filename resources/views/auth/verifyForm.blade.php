@extends('layouts.app')

@section('title', 'Verification')

@push('styles')
    @vite(['resources/css/verifyForm.css'])
@endpush

@section('content')
    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('email.verify') }}">
        @csrf
{{--        <input type="hidden" name="token" value="{{ $token }}">--}}

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label for="verification_token">Verification Code:</label>
        <input type="text" name="verification_token" required>

        @if ($errors->has('verification_token'))
            <div class="error">
                {{ $errors->first('verification_token') }}
            </div>
        @endif

        <button type="submit">Verify Email</button>
    </form>
@endsection
