@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Details</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Order #{{ $order->id }}</h5>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Created At:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                <p><strong>Updated At:</strong> {{ $order->updated_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <h4>Items in the Order:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->menuItem->name }}</td>
                        <td>{{ $cartItem->menuItem->description }}</td>
                        <td>₹{{ number_format($cartItem->menuItem->price, 2) }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>₹{{ number_format($cartItem->menuItem->price * $cartItem->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5 class="mt-4">Order Total: ${{ number_format($order->cartItems->sum(fn($item) => $item->menuItem->price * $item->quantity), 2) }}</h5>

        <a href="{{ route('orders') }}" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>
@endsection
