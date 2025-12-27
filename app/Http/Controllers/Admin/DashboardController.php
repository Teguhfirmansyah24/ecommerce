<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'products' => \App\Models\Product::count(),
            'orders' => \App\Models\Order::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_revenue' => \App\Models\Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'low_stock' => \App\Models\Product::where('stock', '<', 10)->count(),
        ];
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
