<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query cho Order với các quan hệ liên quan
        $query = Order::with([
            'user', // nếu có quan hệ user (khách hàng)
            'orderItems', // nếu có quan hệ orderItems
            'orderPaymentMethod', // nếu có quan hệ orderPaymentMethod
        ]);

        // Tìm kiếm nếu có search term
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Lọc theo service step nếu có
        if ($request->filled('status')) {
            $status = $request->status;
            switch ($status) {
                case 'new_order':
                    $query->where('service_step', 'New Order');
                    break;
                case 'diagnosing':
                    $query->where('service_step', 'Diagnosing');
                    break;
                case 'completed':
                    $query->where('service_step', 'Completed');
                    break;
                case 'cancelled':
                    $query->where('service_step', 'Cancelled');
                    break;
                    // Thêm các case khác nếu cần
            }
        }

        // Sắp xếp theo thời gian tạo mới nhất
        $query->orderBy('created_at', 'desc');

        // Phân trang với 5 orders mỗi trang
        $orders = $query->paginate(5)->appends($request->query());

        return view('admin.pages.order_management.index', [
            'orders' => $orders
        ]);
    }

    // public function detail($orderId)
    // {
    //     // Logic to retrieve order details by $orderId
    //     return view('admin.pages.order_management.detail', ['orderId' => $orderId]);
    // }

    public function detail(Order $order)
    {
        // Load các quan hệ liên quan
        $order->load(['user', 'orderItems', 'orderPaymentMethod']);

        return view('admin.pages.order_management.detail', [
            'order' => $order
        ]);
    }

    // public function update(Request $request, $orderId)
    // {
    //     // Logic to update order by $orderId
    //     return redirect()->route('admin.order.index')->with('success', 'Order updated successfully!');
    // }

    public function updateServiceStep(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->service_step = $request->service_step;
        $order->save();

        return redirect()->back()->with('success', 'Service step updated successfully!');
    }

    // public function create()
    // {
    //     // Logic to show create order form
    //     return view('admin.pages.order_management.create');
    // }

    // public function store(Request $request)
    // {
    //     // Logic to store new order
    //     return redirect()->route('admin.order.index')->with('success', 'Order created successfully!');
    // }
}
