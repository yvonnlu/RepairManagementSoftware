<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách orders cùng các quan hệ liên quan
        $orders = Order::with([
            'user', // nếu có quan hệ user (khách hàng)
            'orderItems', // nếu có quan hệ orderItems
            'orderPaymentMethod', // nếu có quan hệ orderPaymentMethod
        ])->get();
        return view('admin.pages.order_management.index', [
            'orders' => $orders
        ]);
    }

    // public function detail($orderId)
    // {
    //     // Logic to retrieve order details by $orderId
    //     return view('admin.pages.order_management.detail', ['orderId' => $orderId]);
    // }

    // public function update(Request $request, $orderId)
    // {
    //     // Logic to update order by $orderId
    //     return redirect()->route('admin.order.index')->with('success', 'Order updated successfully!');
    // }

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
