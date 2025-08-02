<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::withTrashed();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('device_type', 'like', "%{$search}%")
                    ->orWhere('issue_category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by device type (category)
        if ($request->filled('category')) {
            $query->where('device_type', $request->category);
        }

        // Filter by issue category
        if ($request->filled('issue_category')) {
            $query->where('issue_category', $request->issue_category);
        }

        // Get parts with stock status
        $parts = $query->get()->map(function ($part) {
            $part->stock_status = $part->getStockStatusAttribute();
            $part->stock_status_color = $part->getStockStatusColorAttribute();
            return $part;
        });

        // Calculate statistics (only for active parts)
        $activeParts = $parts->filter(function ($part) {
            return $part->deleted_at === null;
        });

        $stats = [
            'total_parts' => $activeParts->count(),
            'total_value' => $activeParts->sum(function ($part) {
                return $part->cost_price * $part->current_stock;
            }),
            'potential_revenue' => $activeParts->sum(function ($part) {
                // Estimate potential revenue (cost_price * 2.5 multiplier * stock)
                return $part->cost_price * 2.5 * $part->current_stock;
            }),
            'low_stock_count' => $activeParts->filter->isLowStock()->count(),
        ];

        // Get low stock parts (only active ones)
        $lowStockParts = $activeParts->filter->isLowStock();

        // Get unique device types for filter
        $categories = Part::withTrashed()->distinct()->pluck('device_type')->sort()->values();

        return view('admin.pages.inventory_management.list', compact(
            'parts',
            'stats',
            'lowStockParts',
            'categories'
        ));
    }

    public function detail(Part $part)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'part' => $part->load('lastOrder'),
                'last_movement' => [
                    'date' => $part->last_movement_date,
                    'type' => $part->last_movement_type,
                    'quantity' => $part->last_movement_quantity,
                    'reason' => $part->last_movement_reason,
                    'notes' => $part->last_movement_notes,
                    'order_id' => $part->last_order_id
                ]
            ]);
        }

        return view('admin.pages.inventory_management.detail', compact('part'));
    }

    public function create()
    {
        $deviceTypes = Part::distinct()->pluck('device_type')->sort()->values();
        $issueCategories = Part::distinct()->pluck('issue_category')->sort()->values();

        // Lấy dữ liệu từ bảng services để tạo mapping device_type -> issue_category
        $servicesMapping = Services::select('device_type_name', 'issue_category_name')
            ->distinct()
            ->get()
            ->groupBy('device_type_name')
            ->map(function ($services) {
                return $services->pluck('issue_category_name')->unique()->sort()->values();
            });

        return view('admin.pages.inventory_management.create', compact('deviceTypes', 'issueCategories', 'servicesMapping'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'device_type' => 'required|string|max:255',
            'issue_category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255'
        ]);

        $part = Part::create($validated);

        // Create initial stock movement using the new method
        if ($validated['current_stock'] > 0) {
            $part->addStock(
                $validated['current_stock'],
                'initial_stock',
                'Initial stock entry'
            );
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Part added successfully!');
    }

    public function edit(Part $part)
    {
        $deviceTypes = Part::distinct()->pluck('device_type')->sort()->values();
        $issueCategories = Part::distinct()->pluck('issue_category')->sort()->values();

        // Lấy dữ liệu từ bảng services để tạo mapping device_type -> issue_category
        $servicesMapping = Services::select('device_type_name', 'issue_category_name')
            ->distinct()
            ->get()
            ->groupBy('device_type_name')
            ->map(function ($services) {
                return $services->pluck('issue_category_name')->unique()->sort()->values();
            });

        return view('admin.pages.inventory_management.edit', compact('part', 'deviceTypes', 'issueCategories', 'servicesMapping'));
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'device_type' => 'required|string|max:255',
            'issue_category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255'
        ]);

        // Update the part with validated data (no current_stock field)
        $part->update($validated);

        // Handle AJAX requests from detail page
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Part updated successfully!',
                'part' => $part->fresh()
            ]);
        }

        // Redirect to detail page if coming from detail page
        if ($request->has('from_detail')) {
            return redirect()->route('admin.inventory.detail', $part)
                ->with('success', 'Part updated successfully!');
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Part updated successfully!');
    }

    public function destroy(Part $part)
    {
        $part->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Part deleted successfully']);
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Part deleted successfully!');
    }

    public function addStock(Request $request, Part $part)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        // Use the new addStock method from Part model
        $success = $part->addStock(
            $validated['quantity'],
            'purchase',
            $validated['notes'] ?? 'Stock added'
        );

        if (!$success) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => 'Failed to add stock'
                ], 400);
            }
            return redirect()->back()->with('error', 'Failed to add stock!');
        }

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Stock added successfully',
                'part' => $part,
                'new_stock' => $part->current_stock
            ]);
        }

        return redirect()->back()->with('success', 'Stock added successfully!');
    }

    public function restore($id)
    {
        try {
            // Find the soft-deleted part by ID
            $part = Part::withTrashed()->findOrFail($id);

            // Restore part
            $part->restore();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Part has been restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.index')
                ->with('error', 'Failed to restore part. Please try again.');
        }
    }

    // Method để trừ stock khi order completion
    public static function deductStockForOrder($orderId)
    {
        $order = \App\Models\Order::with('orderItems.service')->findOrFail($orderId);

        foreach ($order->orderItems as $item) {
            $service = $item->service;

            // Tìm part tương ứng với service
            $part = Part::forService($service->device_type_name, $service->issue_category_name)->first();

            if ($part && $part->current_stock > 0) {
                try {
                    $part->removeStock(
                        1, // Mỗi service sử dụng 1 part
                        'repair_used',
                        $orderId,
                        "Used for order #{$orderId} - {$service->description}"
                    );
                } catch (\Exception $e) {
                    // Log lỗi nếu không đủ stock, nhưng không block order
                    Log::warning("Insufficient stock for part {$part->name} in order {$orderId}: " . $e->getMessage());
                }
            }
        }
    }
}
