<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Metrics
        $totalUsers = User::count();
        $ordersToday = Order::whereDate('created_at', now()->toDateString())->count();
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_price');
        
        // Popular Menu Item
        $popularItem = MenuItem::select('menu_items.id', 'menu_items.name', 'menu_items.description', 'menu_items.price')
            ->selectRaw('COUNT(cart_items.id) as orders_count')
            ->join('cart_items', 'cart_items.menu_item_id', '=', 'menu_items.id')
            ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.description', 'menu_items.price')
            ->orderByDesc('orders_count')
            ->first();

        // Pass all menu items
        $menuItems = MenuItem::all(); // Fetch all menu items for the dashboard.

        // Recent Activities
        $recentActivities = User::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'ordersToday',
            'monthlyRevenue',
            'popularItem',
            'menuItems',
            'recentActivities'
        ));
    }

    public function userManagement()
    {
        // Retrieve all users from the data`base
        $users = User::all();
        return view('admin.userManagement', compact('users'));
    }
    
    

    
public function analytics()
{
    // Top Selling Items
    $topSellingItems = DB::table('menu_items')
        ->select('menu_items.name', DB::raw('COUNT(cart_items.id) as orders_count'), DB::raw('SUM(cart_items.quantity * menu_items.price) as total_revenue'))
        ->join('cart_items', 'cart_items.menu_item_id', '=', 'menu_items.id')
        ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.description', 'menu_items.price')
        ->orderBy('orders_count', 'desc')
        ->limit(5)
        ->get();

    // Revenue Trends: Group orders by date for the past 7 days
    $salesTrends = DB::table('orders')
        ->select(DB::raw('DATE(created_at) as date, SUM(total_price) as total_sales'))
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Transform sales trends data for the chart
    $labels = [];
    $data = [];
    foreach ($salesTrends as $trend) {
        $labels[] = $trend->date;
        $data[] = $trend->total_sales;
    }

    // Total Revenue
    $totalRevenue = DB::table('orders')
        ->sum('total_price');

    // Orders Completed
    $completedOrders = DB::table('orders')
        ->where('status', 'completed')
        ->count();

    // Active Users
    $activeUsers = DB::table('users')
        ->where('last_login_at', '>=', Carbon::now()->subDays(30)) // Assuming 'last_login_at' is updated for active users
        ->count();

    return view('admin.analytics', [
        'topSellingItems' => $topSellingItems,
        'labels' => $labels,
        'data' => $data,
        'totalRevenue' => $totalRevenue,
        'completedOrders' => $completedOrders,
        'activeUsers' => $activeUsers,
    ]);

}

    // Show the dashboard page
   

    // Show all orders (with pagination)
    public function showOrders()
{
    $orders = Order::all(); // Get all orders
    $pendingOrders = Order::where('status', 'pending')->get(); // Get only pending orders

    return view('admin.orders.index', compact('orders', 'pendingOrders'));
}


    // Show pending orders
    public function showPendingOrders()
    {
        // Retrieve only pending orders with pagination
        $pendingOrders = Order::with(['cartItems.menuItem'])->where('status', 'pending')->paginate(10);
        
        // Return the view for pending orders
        return view('admin.orders.pending', compact('pendingOrders'));
    }

    // Show the details of a specific order
    public function showOrderDetails(Order $order)
    {
        // Load the order with associated cart items and menu items
        $order->load('cartItems.menuItem');
        
        // Return the view with order details
        return view('admin.orders.show', compact('order'));
    }

    // Update the status of an order
    public function updateOrderStatus(Request $request, $orderId)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:pending,completed,canceled',
        ]);

        // Find the order by ID
        $order = Order::findOrFail($orderId);
        
        // Update the order's status
        $order->status = $request->status;
        $order->save();

        // Redirect back to orders page with a success message
        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully');
    }
}


    

