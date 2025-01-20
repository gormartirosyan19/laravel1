@extends('layouts.app')

@section('title', 'Edit Address')
@push('styles')
    @vite(['resources/css/editAddress.css'])
@endpush
@section('content')
    <h1>Edit Address</h1>

    <form action="{{ route('address.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- This tells Laravel to use the PUT method for updates -->
        <div class="mb-3">
            <label for="type" class="form-label">Address Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="shipping" {{ old('type', $address->type) == 'shipping' ? 'selected' : '' }}>Shipping</option>
                <option value="billing" {{ old('type', $address->type) == 'billing' ? 'selected' : '' }}>Billing</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address_line1" class="form-label">Address Line 1</label>
            <input type="text" name="address_line1" id="address_line1" class="form-control" value="{{ old('address_line1', $address->address_line1) }}" required>
        </div>

        <div class="mb-3">
            <label for="address_line2" class="form-label">Address Line 2</label>
            <input type="text" name="address_line2" id="address_line2" class="form-control" value="{{ old('address_line2', $address->address_line2) }}">
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $address->city) }}" required>
        </div>

        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $address->state) }}" required>
        </div>

        <div class="mb-3">
            <label for="zip" class="form-label">Zip Code</label>
            <input type="text" name="zip" id="zip" class="form-control" value="{{ old('zip', $address->zip) }}" required>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $address->country) }}" required>
        </div>

        <div class="mb-3">
            <label for="is_default" class="form-check-label">Set as Default Address</label>
            <input type="checkbox" name="is_default" id="is_default" class="form-check-input" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-primary">Update Address</button>
    </form>
@endsection
