<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Part;
use Carbon\Carbon;
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

    public function getRevenueData(Request $request)
    {
        $type = $request->get('type', 'weekly');

        if ($type === 'weekly') {
            return $this->getWeeklyRevenue();
        } else {
            return $this->getMonthlyRevenue();
        }
    }

    private function getWeeklyRevenue()
    {
        // Get revenue for last 4 weeks
        $revenueData = Order::select(
            DB::raw('WEEK(created_at, 1) as week_number'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total) as revenue')
        )
            ->where('created_at', '>=', now()->subWeeks(4))
            ->where('service_step', 'completed') // Only completed orders
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('WEEK(created_at, 1)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('WEEK(created_at, 1)'), 'asc')
            ->get();

        // Fill in missing weeks with 0 revenue
        $completeData = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekLabel = "Week " . (4 - $i);
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekNumber = $weekStart->week;
            $year = $weekStart->year;

            // Find existing data for this week
            $existingData = $revenueData->first(function ($item) use ($weekNumber, $year) {
                return $item->week_number == $weekNumber && $item->year == $year;
            });

            $completeData[] = [
                'period' => $weekLabel,
                'revenue' => $existingData ? (float) $existingData->revenue : 0
            ];
        }

        return response()->json($completeData);
    }

    private function getMonthlyRevenue()
    {
        // Get revenue for last 12 months
        $revenueData = Order::select(
            DB::raw('MONTH(created_at) as month_number'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total) as revenue')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->where('service_step', 'completed') // Only completed orders
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
            ->get();

        // Fill in missing months with 0 revenue
        $completeData = [];
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthNumber = $monthStart->month;
            $year = $monthStart->year;
            $monthLabel = $monthNames[$monthNumber - 1];

            // Find existing data for this month
            $existingData = $revenueData->first(function ($item) use ($monthNumber, $year) {
                return $item->month_number == $monthNumber && $item->year == $year;
            });

            $completeData[] = [
                'period' => $monthLabel,
                'revenue' => $existingData ? (float) $existingData->revenue : 0
            ];
        }

        return response()->json($completeData);
    }
}
