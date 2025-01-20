@extends('layouts.app')
@push('styles')
    @vite(['resources/css/ordered.css'])
@endpush
@section('content')
    <div class="order-success">
        <h2>Thank you for your order!</h2>
        <p>Your order has been successfully placed. You will receive a confirmation email shortly.</p>
        <a href="{{ route('orders.index') }}" class="btn btn-primary">My order list</a>
    </div>
@endsection

