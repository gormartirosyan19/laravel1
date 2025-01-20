@extends('layouts.app')

@section('title', 'Cart')

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@section('content')
    @if (session('status'))
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
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        @if($cartItems->isEmpty())
            <div class="alert alert-info">Your cart is empty.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>
                            <a href="{{ route('products.show',  $item->product->id)}}">
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                     alt="{{ $item->product->title }}"
                                     style="width: 80px; height: auto;">
                            </a>

                        </td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>{{ $item->product->size ?  : '-' }}</td>
                        <td>{{$item->product->color ? : '-'}}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item->product->id) }}" class="d-flex cart-form" id="cart-form-{{ $item->product->id }}">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary decrease-btn" data-product-id="{{ $item->product->id }}">-</button>
                                    <input type="number" name="quantity" id="quantity-{{ $item->product->id }}" class="form-control me-2 quantity-input" value="{{ $item->quantity }}" min="1" readonly>
                                    <button type="button" class="btn btn-outline-secondary increase-btn" data-product-id="{{ $item->product->id }}">+</button>
                                </div>
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}" />
                            </form>


                        </td>
                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.destroy', $item->product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <h4>Total: ${{ number_format($cartItems->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }), 2) }}</h4>
                <a href="{{ route('cart.checkout') }}" class="btn checkout">Proceed to Checkout</a>
            </div>
        @endif
    </div>
@endsection
