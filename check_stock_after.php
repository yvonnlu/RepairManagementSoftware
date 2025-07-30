<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Part;

// Get the order ID we saved
$orderId = file_get_contents('test_order_id.txt');
$order = Order::with('orderItems.service')->find($orderId);

if ($order) {
    echo "Order ID: {$order->id} - Service Step: {$order->service_step}\n";
    
    echo "\nChecking stock levels AFTER completion:\n";
    foreach($order->orderItems as $item) {
        if ($item->service) {
            $part = Part::where('device_type', $item->service->device_type_name)
                        ->where('issue_category', $item->service->issue_category_name)
                        ->first();
            if ($part) {
                echo "Part: {$part->name} - Current Stock: {$part->current_stock}\n";
                echo "  Total In: {$part->total_in} | Total Out: {$part->total_out}\n";
                echo "  Last Movement: {$part->last_movement_type} - {$part->last_movement_reason}\n";
                echo "  Last Order ID: {$part->last_order_id}\n\n";
            }
        }
    }
    
    // Check logs
    echo "=== Recent Log Entries ===\n";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logs = file_get_contents($logFile);
        $lines = explode("\n", $logs);
        $recentLines = array_slice($lines, -20); // Last 20 lines
        foreach($recentLines as $line) {
            if (strpos($line, 'Stock deducted') !== false || 
                strpos($line, 'Inventory stock') !== false ||
                strpos($line, 'No matching part') !== false) {
                echo $line . "\n";
            }
        }
    }
} else {
    echo "Order not found!\n";
}
?>
