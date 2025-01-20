@extends('layouts.app')
@push('styles')
    @vite(['resources/css/orders.css'])
@endpush

@section('content')
    <div class="orders-container">
        <h2>Your Orders</h2>

        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            @foreach($orders as $order)
                <div class="order">
                    <h4>{{ $order->created_at->format('d M Y') }}</h4>
                    <p>{{ ucfirst($order->status) }}</p>
                    <p>${{ number_format($order->total_amount, 2) }}</p>

                    <ul>
                        @foreach($order->items as $item)
                            <li>
                                <div style="display: flex; align-items: center;">
                                    <img src="{{ asset('storage/'. $item->product->images->first()->image_path )?? asset('default-image.jpg') }}"
                                         alt="{{ $item->product->title }}"
                                         style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">

                                    <div>
                                        <strong>{{ $item->product->title }}</strong><br>
                                        Quantity: {{ $item->quantity }}<br>
                                        Price: ${{ number_format($item->price, 2) }}<br>
                                        Total: ${{ number_format($item->total, 2) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <hr>
            @endforeach
        @endif
    </div>
@endsection
