{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Order Details - Order ID: {{ $order->id }}</h1>

    <h4>Status: {{ ucfirst($order->status) }}</h4>
    <h4>Total Price: ₹{{ $order->total_price }}</h4>

    <h5>Items in this Order:</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->cartItems as $item)
                <tr>
                    <td>{{ $item->menuItem->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ $item->menuItem->price * $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Update Status Form -->
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
        @csrf
        <label for="status">Update Status:</label>
        <select name="status" id="status">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
        </select>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back to Orders</a>
@endsection
