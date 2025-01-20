@extends('layouts.app')

@section('title', $product->title)

@push('styles')
    @vite('resources/css/productDetails.css')
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
    <div class="product">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($product->images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->title }}"
                             style="width: 100%; height: auto;">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-scrollbar"></div>
        </div>

        <div class="product-details">
            <h1>{{ $product->title }}</h1>
            @if ($product->price)
                <div class="form-group">
                    <p>${{ number_format($product->price, 2) }}</p>
                </div>
            @endif

            @if ($product->description)
                <div class="form-group">
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                {{-- Color Dropdown --}}
                @if ($product->color)
                    <div class="form-group">
                        <label for="color"><strong>Color:</strong></label>
                        <select id="color" name="color" class="form-control">
                            <option value="{{ $product->color }}" selected>{{ ucfirst($product->color) }}</option>
                        </select>
                    </div>
                @endif

                {{-- Size Dropdown --}}
                @if ($product->size)
                    <div class="form-group">
                        <label for="size"><strong>Size:</strong></label>
                        <select id="size" name="size" class="form-control">
                            <option value="{{ $product->size }}" selected>{{ ucfirst($product->size) }}</option>
                        </select>
                    </div>
                @endif

                {{-- Quantity Selector --}}
                <div class="form-group">
                    <div class="quantity-selector">
                        <button type="button" class="btn btn-outline-secondary" id="decrease-quantity">-</button>
                        <input type="number" id="quantity" name="quantity" class="form-control quantity-input" value="1"
                               min="1" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="increase-quantity">+</button>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="form-group action-buttons">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="hidden-quantity" value="1"> <!-- Default quantity -->

                        <div class="form-group action-buttons">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" id="add-to-cart">Add to Cart</button>
                        </div>
                    </form>

                    <form action="{{ route('wishlist.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="wishlist-icon wishlist-toggle" data-product-id="{{ $product->id }}">
                            <i class="fa-heart {{ $product->wishlist->where('user_id', auth()->id())->isNotEmpty() ? 'fas' : 'far' }}" style="color: red;"></i>
                        </div>


                    </form>

                </div>
            </form>

        </div>
    </div>
@endsection
