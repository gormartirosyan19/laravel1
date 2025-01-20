@extends('layouts.app')

@push('styles')
    @vite('resources/css/allProducts.css')
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

    <div class="allProds">
        <h1>All Products</h1>

        @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
            <a href="{{ route('products.create') }}" class="create-btn">Create New Product</a>
        @endif

        <ul class="products-list">
            @forelse ($products as $product)
                <li class="product-item">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product-content">
                            <div class="image">
                                @if ($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                         alt="{{ $product->title }}" class="w-32 h-32">
                                @else
                                    <p>No product image available</p>
                                @endif
                            </div>
                            <h3>{{ $product->title }}</h3>
                            <p>{{ Str::limit($product->description, 100) }}</p>
                            <small>${{ $product->price }}</small>
                        </div>
                    </a>
                    <div class="product-actions">
                        @if ($product->user_id == Auth::id() || Auth::user()->hasRole('admin'))
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="wishlist-icon wishlist-toggle" data-product-id="{{ $product->id }}">
                        <i class="fa-heart {{ $product->wishlist->where('user_id', auth()->id())->isNotEmpty() ? 'fas' : 'far' }}" style="color: red;"></i>
                    </div>


                </li>
            @empty
                <p>No products available.</p>
            @endforelse
        </ul>
    </div>
@endsection
