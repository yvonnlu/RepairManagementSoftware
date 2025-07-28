<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả user kể cả đã soft delete, đếm orders
        $query = User::withTrashed()->withCount('orders');

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

    public function destroy(User $customer)
    {
        try {
            // Soft delete user
            $customer->delete();

            return redirect()->route('admin.customer.index')
                ->with('success', 'Customer has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.customer.index')
                ->with('error', 'Failed to delete customer. Please try again.');
        }
    }

    public function restore($id)
    {
        try {
            // Find the soft-deleted customer by ID
            $customer = User::withTrashed()->findOrFail($id);

            // Kiểm tra email đã tồn tại cho user khác chưa
            $existingUser = User::where('email', $customer->email)
                ->whereNull('deleted_at')
                ->where('id', '!=', $customer->id)
                ->exists();

            if ($existingUser) {
                return redirect()->route('admin.customer.index')
                    ->with('error', 'Cannot restore: Email address is already in use by another active user.');
            }

            // Restore user
            $customer->restore();

            return redirect()->route('admin.customer.index')
                ->with('success', 'Customer has been restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.customer.index')
                ->with('error', 'Failed to restore customer. Please try again.');
        }
    }

    public function create()
    {
        return view('admin.pages.customer_management.create');
    }

    public function store(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|numeric|digits_between:10,15',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'phone_number.numeric' => 'Phone number must contain only numbers.',
            'phone_number.digits_between' => 'Phone number must be between 10 and 15 digits.',
            'address.max' => 'Address cannot exceed 500 characters.',
        ]);

        try {
            // Create new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'phone_number' => $validatedData['phone_number'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'email_verified_at' => now(), // Auto verify for admin-created users
            ]);

            return redirect()->route('admin.customer.index')
                ->with('success', 'Customer "' . $user->name . '" has been created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create customer. Please try again.');
        }
    }
}
