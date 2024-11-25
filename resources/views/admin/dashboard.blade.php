@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>

    <!-- Metrics Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Orders Today</h5>
                    <h3>{{ $ordersToday }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Monthly Revenue</h5>
                    <h3>${{ number_format($monthlyRevenue, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Item Overview -->
    <div class="mb-4">
        <h3>Menu Items and Order Counts</h3>
        <div class="row">
            @foreach ($menuItems as $menuItem)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $menuItem->name }}</h5>
                            <p>Orders: {{ $menuItem->orders_count }}</p> <!-- This will show the number of orders for this menu item -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
