@extends('layouts.app')

@section('title', 'Welcome Page')

@push('styles')
    @vite(['resources/css/welcome.css'])
@endpush

@section('content')

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Our World!</h1>
            <p>Discover amazing posts, products, and more. Join our journey.</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Shop Now</a>
        </div>
    </section>

    <section class="posts-section">
        <h2 class="section-title">Latest Posts</h2>
        <div class="posts-container">
            @foreach($posts as $post)
                <div class="post-card">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <div class="image">
                            <img src="{{ asset('storage/'.$post->image_url) }}" alt="Post Image" class="post-image">
                        </div>
                        <div class="post-content">
                            <h3 class="post-title">{{ $post->title }}</h3>
                            <p>{{ Str::limit($post->content, 100) }}</p>
                            <a href="{{ route('posts.show', $post->id) }}" class="read-more-btn">Read More</a>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="products-section">
        <h2 class="section-title">Latest Products</h2>
        <div class="products-container">
            @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{route('products.show', $product->id)}}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->title }} image">
                        @endif
                        <h2>{{ $product->title }}</h2>
                        <p>{{ $product->description }}</p>
                        </a>
                    </div>

            @endforeach
        </div>
    </section>


    <section class="about-us">
        <h2 class="section-title">About Us</h2>
        <p>We are a passionate team dedicated to providing the best products and content for you. Our mission is to make your life better with quality and innovation. Stay tuned for more!</p>
    </section>

    <section class="testimonials">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="testimonial-cards">
            <div class="testimonial-card">
                <p>"This is the best purchase I’ve ever made! Quality and service were exceptional." - John Doe</p>
            </div>
            <div class="testimonial-card">
                <p>"Incredible experience, I’m a customer for life!" - Jane Smith</p>
            </div>
        </div>
    </section>

@endsection
