<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Low stock items từ database thật
        $lowStockItems = Part::where('current_stock', '<=', DB::raw('min_stock_level'))
            ->orderByRaw('(current_stock / GREATEST(min_stock_level, 1)) ASC') // Sắp xếp theo tỷ lệ thiếu hụt
            ->orderBy('cost_price', 'desc') // Part đắt ưu tiên cao hơn
            ->take(10) // Giới hạn 10 items
            ->get()
            ->map(function ($part) {
                // Tính toán mức độ ưu tiên
                if ($part->current_stock == 0) {
                    $urgency = 'high';
                } else {
                    $ratio = $part->current_stock / max($part->min_stock_level, 1);
                    if ($ratio <= 0.2) {
                        $urgency = 'high';
                    } elseif ($ratio <= 0.5) {
                        $urgency = 'medium';
                    } else {
                        $urgency = 'low';
                    }
                }

                return [
                    'id' => $part->id,
                    'name' => $part->name,
                    'device_type' => $part->device_type,
                    'issue_category' => $part->issue_category,
                    'current' => $part->current_stock,
                    'minimum' => $part->min_stock_level,
                    'cost_price' => $part->cost_price,
                    'location' => $part->location,
                    'urgency' => $urgency,
                    'shortage' => max(0, $part->min_stock_level - $part->current_stock),
                    'last_movement' => $part->last_movement_date?->diffForHumans(),
                ];
            });

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
