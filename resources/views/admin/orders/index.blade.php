@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Orders</h1>

    <!-- Toggle Button to switch between All Orders and Pending Orders -->
    <div class="btn-group" role="group" aria-label="Order View Toggle">
        <button id="allOrdersBtn" type="button" class="btn btn-primary active" onclick="toggleOrders('all')">All Orders</button>
        <button id="pendingOrdersBtn" type="button" class="btn btn-secondary" onclick="toggleOrders('pending')">Pending Orders</button>
    </div>

    <div class="mt-3">
        <!-- All Orders Section -->
        <div id="allOrders" class="order-section">
            <h3>All Orders</h3>
            @foreach ($orders as $order)
                <div class="order">
                    <p>Order #{{ $order->id }} - Status: {{ $order->status }}</p>
                    <!-- You can add any other details you need here, like customer info -->
                </div>
            @endforeach
        </div>

        <!-- Pending Orders Section -->
        <div id="pendingOrders" class="order-section" style="display: none;">
            <h3>Pending Orders</h3>
            @foreach ($pendingOrders as $order)
                <div class="order">
                    <p>Order #{{ $order->id }} - Status: {{ $order->status }}</p>
                    <!-- Add any other pending order details -->
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Function to toggle between All Orders and Pending Orders
    function toggleOrders(view) {
        // Hide both sections first
        document.getElementById('allOrders').style.display = 'none';
        document.getElementById('pendingOrders').style.display = 'none';

        // Show the selected section
        if (view === 'all') {
            document.getElementById('allOrders').style.display = 'block';
            document.getElementById('allOrdersBtn').classList.add('active');
            document.getElementById('pendingOrdersBtn').classList.remove('active');
        } else {
            document.getElementById('pendingOrders').style.display = 'block';
            document.getElementById('pendingOrdersBtn').classList.add('active');
            document.getElementById('allOrdersBtn').classList.remove('active');
        }
    }
</script>
@endsection
