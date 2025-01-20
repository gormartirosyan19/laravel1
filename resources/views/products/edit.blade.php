@extends('layouts.app')

@push('styles')
    @vite('resources/css/editProduct.css')
@endpush

@section('content')
    <h1>Edit Product</h1>

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $product->title) }}" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description">Description</label>
            <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Price -->
        <div>
            <label for="price">Price</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" required step="0.01">
        </div>

        <!-- Color -->
        <div>
            <label for="color">Color</label>
            <input type="text" name="color" value="{{ old('color', $product->color) }}">
        </div>

        <!-- Size -->
        <div>
            <label for="size">Size</label>
            <select name="size">
                <option value=""  {{ old('size') == '' ? 'selected' : '' }}>Not Selected</option>
                <option value="big" {{ old('size', $product->size) == 'big' ? 'selected' : '' }}>Big</option>
                <option value="mid" {{ old('size', $product->size) == 'mid' ? 'selected' : '' }}>Medium</option>
                <option value="small" {{ old('size', $product->size) == 'small' ? 'selected' : '' }}>Small</option>
            </select>
        </div>

        <!-- Stock -->
        <div>
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <!-- Product Image -->
        <div class="form-group">
            <label for="images">Product Images:</label>
            <div class="images">
                @if($product->images->isNotEmpty())
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->title }}" class="w-32 h-32">
                    @endforeach
                @else
                    <p>No product image available. Upload a new image.</p>
                @endif
            </div>
            <input type="file" name="images[]" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
@endsection
