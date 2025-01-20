@extends('layouts.app')

@section('title', 'Add Product')

@push('styles')
    @vite(['resources/css/product.css'])
@endpush

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Add Product</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded px-8 py-6">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full border rounded px-4 py-2" value="{{ old('title') }}" required>
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full border rounded px-4 py-2">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="number" step="0.01" id="price" name="price" class="w-full border rounded px-4 py-2" value="{{ old('price') }}" required>
                @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Color -->
            <div class="mb-4">
                <label for="color" class="block text-gray-700">Color</label>
                <input type="text" id="color" name="color" class="w-full border rounded px-4 py-2" value="{{ old('color') }}">
                @error('color') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Size -->
            <div class="mb-4">
                <label for="size" class="block text-gray-700">Size</label>
                <select id="size" name="size" class="w-full border rounded px-4 py-2">
                    <option value="" disabled {{ old('size') == '' ? 'selected' : '' }}>Not Selected</option>
                    <option value="big" {{ old('size') == 'big' ? 'selected' : '' }}>Big</option>
                    <option value="mid" {{ old('size') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Small</option>
                </select>
                @error('size') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>


            <!-- Stock -->
            <div class="mb-4">
                <label for="stock" class="block text-gray-700">Stock</label>
                <input type="number" id="stock" name="stock" class="w-full border rounded px-4 py-2" value="{{ old('stock') }}" required>
                @error('stock') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Images -->
            <div class="mb-4">
                <label for="images" class="block text-gray-700">Images</label>
                <input type="file" id="images" name="images[]" class="w-full border rounded px-4 py-2" multiple>
                @error('images.*') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Product</button>
            </div>
        </form>
    </div>
@endsection
