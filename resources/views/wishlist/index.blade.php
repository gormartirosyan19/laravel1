@extends('layouts.app')

@section('title', 'Wishlist')

@push('styles')
    @vite(['resources/css/wishlist.css'])
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
    <div class="container">
        @if($wishlistItems->isEmpty())
            <div class="alert alert-info">Your wishlist is empty.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wishlistItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>
                           <a href="{{route('products.show', $item->product->id)}}">
                               <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                    alt="{{ $item->product->title }}"
                                    style="width: 80px; height: auto;">
                           </a>
                        </td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('wishlist.remove', $item->product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
