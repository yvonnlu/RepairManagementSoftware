<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách khách hàng
        $customers = User::where('role', 'customer')->withCount('orders')->get();
        return view('admin.pages.customer_management.index',['customers' => $customers]);
    }
}
