@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Analytics Dashboard</h1>

    <div class="row">
        <!-- Metrics Overview -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Completed Orders</h5>
                    <h3>{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Active Users</h5>
                    <h3>{{ $activeUsers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Trends Chart -->
    <div class="mb-4 mt-4">
        <h4>Sales Trends (Last 7 Days)</h4>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Top Selling Items -->
    <div class="mb-4">
        <h4>Top Selling Items</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Orders Count</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topSellingItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->orders_count }}</td>
                    <td>${{ number_format($item->total_revenue, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Sales',
                data: @json($data),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
