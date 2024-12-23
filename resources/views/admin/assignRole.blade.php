@extends('layouts.app')

@section('content')
    <h1>Manage User Roles</h1>
    <ul>
        @foreach ($users as $user)
            <li>
                {{ $user->name }}
                <form method="POST" action="{{ route('assign.role', $user->id) }}">
                    @csrf
                    <button type="submit">Assign Admin Role</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
