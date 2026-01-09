<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'monthlyOrders', 'dailyRevenue'));
    }
}
