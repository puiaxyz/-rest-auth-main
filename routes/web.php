<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMenuController;
// -------------------------------------
// Public Routes
// -------------------------------------

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/menu', fn() => view('menu'))->name('menu');

// -------------------------------------
// Authentication Routes
// -------------------------------------

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset (Optional)
Route::get('/password/reset', [LoginController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [LoginController::class, 'reset'])->name('password.update');

// -------------------------------------
// Protected Routes (Authenticated Users)
// -------------------------------------

// Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');

    // Orders
    Route::get('/orders', [OrderController::class, 'showOrdersView'])->name('orders');
    Route::get('/orders/{orderId}/details', [OrderController::class, 'showOrderDetails'])->name('orders.details');



    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
});

// -------------------------------------
// Role-Based Routes
// -------------------------------------

// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', fn() => view('customer.dashboard'))->name('customer.dashboard');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
    Route::patch('/staff/orders/{orderId}/update', [StaffDashboardController::class, 'updateOrderStatus'])->name('staff.orders.update');
});


    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
        // Show all orders (with pagination)
        Route::get('/orders', [AdminDashboardController::class, 'showOrders'])->name('orders.index');
        
        // Show pending orders
        Route::get('/orders/pending', [AdminDashboardController::class, 'showPendingOrders'])->name('orders.pending');
        
        // Show specific order details
        Route::get('/orders/{order}', [AdminDashboardController::class, 'showOrderDetails'])->name('orders.show');
        
        // Update order status
        Route::post('/orders/{orderId}/update-status', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    
        // User Management Routes
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/admin/user-management', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/admin/menu', [AdminMenuController::class, 'index'])->name('admin.menu');

        // Menu Management
        Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu');
        Route::post('/menu-items', [AdminMenuController::class, 'store'])->name('menu-items.store');
        Route::get('/menu-items/{menuItem}/edit', [AdminMenuController::class, 'edit'])->name('menu-items.edit');
        Route::put('/menu-items/{menuItem}', [AdminMenuController::class, 'update'])->name('menu-items.update');
        Route::delete('/menu-items/{menuItem}', [AdminMenuController::class, 'destroy'])->name('menu-items.destroy');
        
        // Additional Admin Pages (User Management, Analytics)
        Route::get('/user-management', [AdminDashboardController::class, 'userManagement'])->name('userManagement');
        Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
    });
    
