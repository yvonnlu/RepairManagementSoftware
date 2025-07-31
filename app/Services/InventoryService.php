<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Part;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryService
{
    /**
     * Process inventory stock when order service step changes to completed
     * 
     * @param Order $order
     * @return bool
     */
    public function processCompletedOrderStock(Order $order)
    {
        try {
            DB::beginTransaction();

            // Get all order items for this order
            $orderItems = $order->orderItems()->get();

            foreach ($orderItems as $orderItem) {
                // Get device_type and issue_category from service or custom fields
                $deviceType = null;
                $issueCategory = null;

                if ($orderItem->service_id && $orderItem->service) {
                    // Use data from Services table if standard service
                    $deviceType = $orderItem->service->device_type_name;
                    $issueCategory = $orderItem->service->issue_category_name;
                } elseif ($orderItem->custom_device_type && $orderItem->custom_issue_category) {
                    // Use custom fields for custom services
                    $deviceType = $orderItem->custom_device_type;
                    $issueCategory = $orderItem->custom_issue_category;
                }

                // Skip if we don't have both device_type and issue_category
                if (!$deviceType || !$issueCategory) {
                    Log::warning('Missing device_type or issue_category for order item', [
                        'order_id' => $order->id,
                        'order_item_id' => $orderItem->id,
                        'service_id' => $orderItem->service_id,
                        'device_type' => $deviceType,
                        'issue_category' => $issueCategory
                    ]);
                    continue;
                }

                // Find matching part based on device_type and issue_category
                $part = Part::where('device_type', $deviceType)
                    ->where('issue_category', $issueCategory)
                    ->where('current_stock', '>', 0)
                    ->first();

                if ($part) {
                    // Calculate quantity to deduct (default 1 per order item)
                    $quantityToDeduct = $orderItem->qty ?? 1;

                    // Use the new removeStock method
                    $success = $part->removeStock(
                        $quantityToDeduct,
                        'repair_used',
                        $order->id,
                        "Used for Order #{$order->id} - {$orderItem->name}"
                    );

                    if ($success) {
                        Log::info('Stock deducted successfully', [
                            'order_id' => $order->id,
                            'part_id' => $part->id,
                            'part_name' => $part->name,
                            'quantity_deducted' => $quantityToDeduct,
                            'remaining_stock' => $part->current_stock
                        ]);
                    } else {
                        Log::warning('Insufficient stock for order completion', [
                            'order_id' => $order->id,
                            'part_id' => $part->id,
                            'part_name' => $part->name,
                            'requested_quantity' => $quantityToDeduct,
                            'available_stock' => $part->current_stock
                        ]);

                        // Continue processing other items even if one has insufficient stock
                        continue;
                    }
                } else {
                    Log::warning('No matching part found for order item', [
                        'order_id' => $order->id,
                        'order_item_id' => $orderItem->id,
                        'device_type' => $deviceType,
                        'issue_category' => $issueCategory,
                        'service_id' => $orderItem->service_id
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process completed order stock', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Restore inventory stock when order is cancelled or reverted from completed
     * 
     * @param Order $order
     * @return bool
     */
    public function restoreOrderStock(Order $order)
    {
        try {
            DB::beginTransaction();

            // Find all parts that were used for this order (last_order_id = order->id)
            $parts = Part::where('last_order_id', $order->id)
                ->where('last_movement_type', 'out')
                ->where('last_movement_reason', 'repair_used')
                ->get();

            foreach ($parts as $part) {
                // Restore the stock using addStock method
                $success = $part->addStock(
                    $part->last_movement_quantity,
                    'adjustment',
                    "Restored from Order #{$order->id} cancellation/revert"
                );

                if ($success) {
                    Log::info('Stock restored successfully', [
                        'order_id' => $order->id,
                        'part_id' => $part->id,
                        'quantity_restored' => $part->last_movement_quantity,
                        'new_stock' => $part->current_stock
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restore order stock', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
