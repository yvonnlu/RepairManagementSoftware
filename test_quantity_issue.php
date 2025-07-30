<?php

// Check current stock of Smartphone Screen before changing Order #77 to Completed
echo "=== BEFORE COMPLETION ===\n";
echo "Order #77: New Order -> Completed\n";  
echo "OrderItem Quantity: 15\n";
echo "Expected: Smartphone Screen stock should decrease by 15\n\n";

echo "To test:\n";
echo "1. Check current Smartphone Screen stock in admin\n";
echo "2. Change Order #77 service_step to 'Completed'\n"; 
echo "3. Check if Smartphone Screen stock decreased by 15\n";
echo "4. Check logs for any 'Stock deducted successfully' messages\n\n";

echo "If stock only decreases by 1 instead of 15, then the issue is confirmed.\n";
?>
