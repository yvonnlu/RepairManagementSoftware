<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả user (không phân biệt role), đếm orders
        $query = User::withCount('orders');

        // Tìm kiếm nếu có search term
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Sắp xếp theo thời gian tạo mới nhất
        $query->orderBy('created_at', 'desc');

        // Phân trang với 5 users mỗi trang
        $customers = $query->paginate(5)->appends($request->query());

        return view('admin.pages.customer_management.index', [
            'customers' => $customers
        ]);
    }

    public function detail(User $customer)
    {
        // Lấy các dữ liệu liên quan: orders với payment method
        $customer->load(['orders.orderPaymentMethod']);
        return view('admin.pages.customer_management.detail', [
            'customer' => $customer
        ]);
    }
}
