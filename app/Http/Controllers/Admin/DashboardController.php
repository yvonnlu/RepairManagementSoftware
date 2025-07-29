<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng doanh thu
        $totalRevenue = Order::sum('total');
        // Tổng số đơn hàng
        $orderCount = Order::count();
        // Số đơn hàng đã hoàn thành
        $completedOrders = Order::where('service_step', 'completed')->count();
        // Tổng số khách hàng
        $totalCustomers = \App\Models\User::count();
        // 5 đơn hàng mới nhất
        $recentOrders = Order::with(['user', 'orderItems.service'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Dữ liệu giả lập cho low stock
        $lowStockItems = [
            [
                'name' => 'iPhone 14 Screen',
                'current' => 3,
                'minimum' => 5,
                'urgency' => 'high',
            ],
            [
                'name' => 'Samsung S23 Battery',
                'current' => 2,
                'minimum' => 3,
                'urgency' => 'medium',
            ],
            [
                'name' => 'MacBook Keyboard',
                'current' => 1,
                'minimum' => 2,
                'urgency' => 'high',
            ],
            [
                'name' => 'iPad Charging Port',
                'current' => 4,
                'minimum' => 5,
                'urgency' => 'low',
            ],
        ];

        // Stats cho dashboard
        $stats = [
            [
                'title' => 'Total Revenue',
                'value' => number_format($totalRevenue, 0, '.', ','),
                'change' => '+12.5%',
                'trend' => 'up',
                'icon' => 'dollar-sign',
                'color' => 'text-green-600',
                'bg' => 'bg-green-50',
                'description' => 'all time total',
            ],
            [
                'title' => 'Orders',
                'value' => $orderCount,
                'change' => '+8',
                'trend' => 'up',
                'icon' => 'shopping-cart',
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-50',
                'description' => 'total orders',
            ],
            [
                'title' => 'Completed Orders',
                'value' => $completedOrders,
                'change' => '+5',
                'trend' => 'up',
                'icon' => 'check-circle',
                'color' => 'text-green-600',
                'bg' => 'bg-green-50',
                'description' => 'finished repairs',
            ],
            [
                'title' => 'Total Customers',
                'value' => $totalCustomers,
                'change' => '+3',
                'trend' => 'up',
                'icon' => 'users',
                'color' => 'text-purple-600',
                'bg' => 'bg-purple-50',
                'description' => 'registered users',
            ],
        ];

        return view('admin.pages.dashboard', compact('stats', 'recentOrders', 'lowStockItems', 'completedOrders', 'totalCustomers'));
    }
}
