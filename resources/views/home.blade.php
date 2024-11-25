@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Welcome to Our Restaurant!</h1>
    <p>We are thrilled to have you visit our online home. Whether you're craving a meal or looking to explore our menu, we're here to serve you with quality food, fast delivery, and excellent service. Explore our website to learn more and make your next order today!</p>

    <h2>What We Offer</h2>
    <ul>
        <li><strong>Delicious Menu:</strong> From classic dishes to new specials, we offer something for everyone.</li>
        <li><strong>Online Ordering:</strong> Conveniently browse our menu, place an order, and track it right from your phone or computer.</li>
        <li><strong>Takeout & Delivery:</strong> Enjoy our meals wherever you are with our efficient takeout and delivery service.</li>
    </ul>

    <h3>Browse Our Menu</h3>
    <p>Ready to make an order? Visit our menu page to see the full list of available dishes, including appetizers, main courses, desserts, and beverages!</p>
    <a href="{{ route('menu') }}" class="btn btn-secondary">View Menu</a>
</div>
@endsection
