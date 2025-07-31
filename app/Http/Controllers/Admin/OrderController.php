<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query cho Order với các quan hệ liên quan, bao gồm cả soft deleted
        $query = Order::withTrashed()->with([
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
        try {
            $request->validate([
                'service_step' => 'required|in:New Order,Diagnosing,Completed,Cancelled'
            ]);

            $order = Order::findOrFail($orderId);
            $oldStep = $order->service_step;
            $newStep = $request->service_step;

            $order->service_step = $newStep;
            $saved = $order->save();

            if ($saved) {
                // Initialize inventory service
                $inventoryService = new InventoryService();

                // Handle inventory stock based on service step changes
                if ($newStep === 'Completed' && $oldStep !== 'Completed') {
                    // Order just completed - deduct stock
                    $stockProcessed = $inventoryService->processCompletedOrderStock($order);

                    if (!$stockProcessed) {
                        Log::warning('Inventory stock processing failed for completed order', [
                            'order_id' => $orderId
                        ]);
                        // Don't fail the service step update, just log the warning
                    }
                } elseif ($oldStep === 'Completed' && $newStep !== 'Completed') {
                    // Order was completed but now changed to different status - restore stock
                    $stockRestored = $inventoryService->restoreOrderStock($order);

                    if (!$stockRestored) {
                        Log::warning('Inventory stock restoration failed for reverted order', [
                            'order_id' => $orderId
                        ]);
                    }
                }

                Log::info('Service step updated successfully', [
                    'order_id' => $orderId,
                    'old_step' => $oldStep,
                    'new_step' => $order->service_step
                ]);

                $successMessage = 'Service step updated successfully from "' . ($oldStep ?? 'New Order') . '" to "' . $order->service_step . '"';

                if ($newStep === 'Completed') {
                    $successMessage .= '. Inventory stock has been updated accordingly.';
                }

                return redirect()->back()->with('success', $successMessage);
            } else {
                return redirect()->back()->with('error', 'Failed to update service step. Please try again.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Invalid service step selected.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Order not found.');
        } catch (\Exception $e) {
            Log::error('Failed to update service step', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating service step. Please try again.');
        }
    }

    public function updatePaymentStatus(Request $request, $orderId)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,success'
            ]);

            Log::info('UpdatePaymentStatus called', [
                'order_id' => $orderId,
                'status' => $request->status,
                'all_request' => $request->all()
            ]);

            $order = Order::findOrFail($orderId);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $saved = $order->save();

            if (!$saved) {
                return redirect()->back()->with('error', 'Failed to update payment status. Please try again.');
            }

            Log::info('Payment status update result', [
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'new_status' => $order->status,
                'saved' => $saved
            ]);

            // Send email if order is marked as paid
            if ($request->status === 'success' && $oldStatus !== 'success') {
                try {
                    // Send email to admin
                    if (config('mail.admin_email')) {
                        Mail::to(config('mail.admin_email'))->queue(new OrderEmailAdmin($order));
                    }

                    // Send email to customer
                    if ($order->user && $order->user->email) {
                        Mail::to($order->user->email)->queue(new OrderEmailCustomer($order));
                    }

                    Log::info('Payment confirmation emails queued for order', ['order_id' => $order->id]);

                    return redirect()->back()->with('success', 'Payment status updated to "Paid" and confirmation emails sent successfully!');
                } catch (\Exception $e) {
                    Log::error('Failed to send payment confirmation emails', [
                        'order_id' => $order->id,
                        'error' => $e->getMessage()
                    ]);

                    return redirect()->back()->with('success', 'Payment status updated successfully, but failed to send confirmation emails.');
                }
            } else {
                $statusText = $request->status === 'success' ? 'Paid' : 'Unpaid';
                return redirect()->back()->with('success', 'Payment status updated to "' . $statusText . '" successfully!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Invalid payment status selected.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Order not found.');
        } catch (\Exception $e) {
            Log::error('Failed to update payment status', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating payment status. Please try again.');
        }
    }

    public function create()
    {
        // Lấy khách hàng được tạo trong 7 ngày gần đây
        $recentCustomers = \App\Models\User::whereIn('role', ['customer', 'user'])
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy các khách hàng được tạo cách đây hơn 7 ngày
        $olderCustomers = \App\Models\User::whereIn('role', ['customer', 'user'])
            ->where('created_at', '<', now()->subDays(7))
            ->orderBy('name', 'asc')
            ->limit(50) // Giới hạn để tránh quá tải
            ->get();

        $services = \App\Models\Services::all();

        // Get unique device types for dropdown
        $deviceTypes = \App\Models\Services::select('device_type_name')
            ->distinct()
            ->orderBy('device_type_name')
            ->pluck('device_type_name');

        return view('admin.pages.order_management.create', compact('recentCustomers', 'olderCustomers', 'services', 'deviceTypes'));
    }

    public function store(Request $request)
    {
        $isCustom = $request->service_type === 'custom';

        // Dynamic validation based on service type
        $rules = [
            'user_id' => 'required|exists:users,id',
            'service_step' => 'required|in:New Order,Diagnosing,Completed,Cancelled',
            'status' => 'required|in:pending,success',
            'service_type' => 'required|in:standard,custom'
        ];

        $messages = [
            'user_id.required' => 'Please select a customer',
            'user_id.exists' => 'Selected customer does not exist',
            'service_step.required' => 'Service step is required',
            'service_step.in' => 'Invalid service step selected',
            'status.required' => 'Payment status is required',
            'status.in' => 'Invalid payment status selected (must be pending or success)'
        ];

        if ($isCustom) {
            // Get available device types for validation
            $availableDeviceTypes = \App\Models\Services::select('device_type_name')
                ->distinct()
                ->pluck('device_type_name')
                ->toArray();

            // Custom service validation
            $rules = array_merge($rules, [
                'custom_description' => 'required|string|min:10|max:500',
                'manual_total' => 'required|numeric|min:0.01',
                'custom_device_type' => 'nullable|in:' . implode(',', $availableDeviceTypes),
                'custom_issue_category' => 'nullable|string|max:100',
                'custom_note' => 'nullable|string|max:1000'
            ]);

            $messages = array_merge($messages, [
                'custom_description.required' => 'Please provide a description for the custom service',
                'custom_description.min' => 'Description must be at least 10 characters',
                'custom_description.max' => 'Description cannot exceed 500 characters',
                'manual_total.required' => 'Please enter the quote amount',
                'manual_total.numeric' => 'Quote amount must be a number',
                'manual_total.min' => 'Quote amount must be greater than $0',
                'custom_device_type.in' => 'Please select a valid device type from the dropdown'
            ]);
        } else {
            // Standard service validation
            $rules = array_merge($rules, [
                'services' => 'required|array|min:1',
                'services.*' => 'exists:services,id',
                'total' => 'required|numeric|min:0'
            ]);

            $messages = array_merge($messages, [
                'services.required' => 'Please select at least one service',
                'services.min' => 'Please select at least one service',
                'services.*.exists' => 'One or more selected services do not exist',
                'total.required' => 'Total amount is required',
                'total.numeric' => 'Total amount must be a number',
                'total.min' => 'Total amount cannot be negative'
            ]);
        }

        $validated = $request->validate($rules, $messages);

        try {
            // Create order
            $orderData = [
                'user_id' => $validated['user_id'],
                'service_step' => $validated['service_step'],
                'status' => $validated['status']
            ];

            if ($isCustom) {
                $orderData['total'] = $validated['manual_total'];
            } else {
                $orderData['total'] = $validated['total'];
            }

            $order = Order::create($orderData);

            if ($isCustom) {
                // Create a custom service entry
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => null, // No standard service
                    'qty' => 1,
                    'price' => $validated['manual_total'],
                    'custom_description' => $validated['custom_description'],
                    'custom_device_type' => $validated['custom_device_type'] ?? 'Custom Service',
                    'custom_issue_category' => $validated['custom_issue_category'] ?? 'Custom Quote',
                    'custom_note' => $validated['custom_note']
                ]);
            } else {
                // Create order items for standard services
                foreach ($validated['services'] as $serviceId) {
                    $service = \App\Models\Services::find($serviceId);

                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'service_id' => $serviceId,
                        'name' => $service->device_type_name . ' - ' . $service->issue_category_name,
                        'qty' => 1,
                        'price' => $service->base_price
                    ]);
                }
            }

            // Send emails if payment status is success (paid)
            if ($validated['status'] === 'success') {
                try {
                    // Load order with user relationship for emails
                    $order->load('user', 'orderItems');

                    // Send email to admin
                    Mail::to(config('mail.admin_email', 'admin@example.com'))->send(new OrderEmailAdmin($order));

                    // Send email to customer
                    if ($order->user && $order->user->email) {
                        Mail::to($order->user->email)->send(new OrderEmailCustomer($order));
                    }
                } catch (\Exception $emailError) {
                    // Log email error but don't fail the order creation
                    Log::error('Failed to send order confirmation emails: ' . $emailError->getMessage());
                }
            }

            $message = $isCustom ? 'Custom quote order created successfully!' : 'Order created successfully!';

            // Add email info to success message if emails were sent
            if ($validated['status'] === 'success') {
                $message .= ' Confirmation emails have been sent.';
            }

            return redirect()->route('admin.order.create')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.order.create')
                ->withInput()
                ->with('error', 'Failed to create order. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            // Soft delete order
            $order->delete();

            return redirect()->route('admin.order.index')
                ->with('success', 'Order has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.order.index')
                ->with('error', 'Failed to delete order. Please try again.');
        }
    }

    public function restore($id)
    {
        try {
            // Find the soft-deleted order by ID
            $order = Order::withTrashed()->findOrFail($id);

            // Restore order
            $order->restore();

            return redirect()->route('admin.order.index')
                ->with('success', 'Order has been restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.order.index')
                ->with('error', 'Failed to restore order. Please try again.');
        }
    }
}
