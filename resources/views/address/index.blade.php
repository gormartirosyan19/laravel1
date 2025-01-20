@extends('layouts.app')

@section('title', 'Addresses')

@push('styles')
    @vite(['resources/css/addresses.css'])
@endpush

@section('content')
    @if (session('success'))
        <div id="success-alert" style="
        position: fixed;
        top: 20px;
        right: -300px;
        background-color: #d4edda;
        color: green;
        border: 1px solid green;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        transition: right 0.5s ease-in-out;">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-3">
        <a href="{{ route('address.add') }}" class="btn btn-primary">Add Address</a>
    </div>

    <h2>Your Addresses</h2>
    @if($addresses->isEmpty())
        <p>You haven't added any addresses yet.</p>
    @else
        <ul class="list-group">
            @foreach($addresses as $address)
                <li class="list-group-item">
                    <strong>{{ $address->type }}</strong>:
                    <p>{{ $address->address_line1 }}</p>
                    @if($address->address_line2)
                        <p>{{ $address->address_line2 }}</p>
                    @endif
                    <p>{{ $address->city }}</p>
                    <p> {{ $address->state }} </p>
                    <p>{{ $address->zip }}</p>
                    <p>{{ $address->country }}</p>
                    @if($address->is_default)
                        <span class="badge bg-success">Default</span>
                    @endif

                    <!-- Edit Button -->
                    <a href="{{ route('address.edit', $address->id) }}"
                       class="btn btn-sm btn-secondary float-end">Edit</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
