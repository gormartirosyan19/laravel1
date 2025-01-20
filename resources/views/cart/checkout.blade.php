@extends('layouts.app')

@push('styles')
    @vite(['resources/css/checkout.css'])
@endpush

@section('content')
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>Checkout</h2>
        </div>

        <div class="checkout-body">
            <div class="shipping-address">
                <h3>Shipping Address</h3>
                @if($user->defaultAddress)
                    <div class="address-info">
                        <p><strong>Address:</strong> {{ $user->defaultAddress->address_line1 }},
                            @if($user->defaultAddress->address_line2) {{ $user->defaultAddress->address_line2 }}, @endif
                            {{ $user->defaultAddress->city }},
                            {{ $user->defaultAddress->state }} -
                            {{ $user->defaultAddress->zip }}</p>
                    </div>
                @else
                    <p>No default address found. Please <a href="{{ route('address.create') }}">add one</a> in your profile.</p>
                @endif

                <p><strong>Note:</strong> You can update your address in your profile if necessary.</p>
            </div>

            @if($cartItems->isNotEmpty())
                <div class="product-info">
                    <h3>Products</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->title }}</td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="cart-total">
                        <p><strong>Total:</strong> ${{ number_format($totalAmount, 2) }}</p>
                    </div>
                </div>

                <div class="checkout-footer">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shipping_address_id" value="{{ $user->defaultAddress->id }}">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            @else
                <p>Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>.</p>
            @endif
        </div>
    </div>
@endsection

{{--@section('styles')--}}
{{--    <style>--}}
{{--        .checkout-container {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .checkout-header {--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .checkout-body {--}}
{{--            display: flex;--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .shipping-address, .product-info {--}}
{{--            width: 48%;--}}
{{--        }--}}

{{--        .form-group {--}}
{{--            margin-bottom: 15px;--}}
{{--        }--}}

{{--        .form-control {--}}
{{--            width: 100%;--}}
{{--            padding: 8px;--}}
{{--            border-radius: 4px;--}}
{{--            border: 1px solid #ccc;--}}
{{--        }--}}

{{--        .product-info .table {--}}
{{--            width: 100%;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}

{{--        .product-info .table th, .product-info .table td {--}}
{{--            text-align: center;--}}
{{--            padding: 8px;--}}
{{--        }--}}

{{--        .cart-total {--}}
{{--            margin-top: 20px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .checkout-footer {--}}
{{--            text-align: center;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}

{{--        .btn-primary {--}}
{{--            background-color: #007bff;--}}
{{--            color: white;--}}
{{--            padding: 10px 20px;--}}
{{--            border-radius: 5px;--}}
{{--            border: none;--}}
{{--        }--}}

{{--        .btn-primary:hover {--}}
{{--            background-color: #0056b3;--}}
{{--        }--}}

{{--        .address-info {--}}
{{--            font-size: 1rem;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}
