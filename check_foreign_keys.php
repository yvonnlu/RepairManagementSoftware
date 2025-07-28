<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== CHECKING FOREIGN KEYS IN DATABASE ===\n\n";

try {
    // 1. Kiểm tra foreign keys bằng INFORMATION_SCHEMA
    echo "1. EXISTING FOREIGN KEYS:\n";
    echo str_repeat("-", 80) . "\n";

    $foreignKeys = DB::select("
        SELECT 
            kcu.CONSTRAINT_NAME as foreign_key_name,
            kcu.TABLE_NAME as table_name,
            kcu.COLUMN_NAME as column_name,
            kcu.REFERENCED_TABLE_NAME as referenced_table,
            kcu.REFERENCED_COLUMN_NAME as referenced_column,
            rc.UPDATE_RULE,
            rc.DELETE_RULE
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu
        JOIN INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS rc 
            ON kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME 
            AND kcu.CONSTRAINT_SCHEMA = rc.CONSTRAINT_SCHEMA
        WHERE kcu.CONSTRAINT_SCHEMA = DATABASE() 
        AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
        ORDER BY kcu.TABLE_NAME, kcu.CONSTRAINT_NAME
    ");

    if (empty($foreignKeys)) {
        echo "❌ NO FOREIGN KEYS FOUND!\n\n";
    } else {
        foreach ($foreignKeys as $fk) {
            echo sprintf(
                "✅ %s.%s -> %s.%s (%s)\n   Rules: UPDATE %s, DELETE %s\n\n",
                $fk->table_name,
                $fk->column_name,
                $fk->referenced_table,
                $fk->referenced_column,
                $fk->foreign_key_name,
                $fk->UPDATE_RULE,
                $fk->DELETE_RULE
            );
        }
    }

    // 2. Kiểm tra cấu trúc bảng orders
    echo "2. ORDERS TABLE STRUCTURE:\n";
    echo str_repeat("-", 80) . "\n";

    $ordersColumns = DB::select("DESCRIBE orders");
    foreach ($ordersColumns as $column) {
        if (str_contains($column->Field, 'user_id') || str_contains($column->Field, '_id')) {
            echo sprintf(
                "📋 %s: %s %s %s\n",
                $column->Field,
                $column->Type,
                $column->Null === 'YES' ? 'NULL' : 'NOT NULL',
                $column->Key ? "({$column->Key})" : ''
            );
        }
    }
    echo "\n";

    // 3. Kiểm tra cấu trúc bảng users
    echo "3. USERS TABLE STRUCTURE:\n";
    echo str_repeat("-", 80) . "\n";

    $usersColumns = DB::select("DESCRIBE users");
    foreach ($usersColumns as $column) {
        if ($column->Field === 'id' || $column->Field === 'deleted_at') {
            echo sprintf(
                "📋 %s: %s %s %s\n",
                $column->Field,
                $column->Type,
                $column->Null === 'YES' ? 'NULL' : 'NOT NULL',
                $column->Key ? "({$column->Key})" : ''
            );
        }
    }
    echo "\n";

    // 4. Kiểm tra tất cả các bảng có cột *_id (potential foreign keys)
    echo "4. ALL TABLES WITH POTENTIAL FOREIGN KEY COLUMNS:\n";
    echo str_repeat("-", 80) . "\n";

    $tables = DB::select("SHOW TABLES");
    $databaseName = DB::select("SELECT DATABASE() as db")[0]->db;

    foreach ($tables as $table) {
        $tableName = $table->{"Tables_in_$databaseName"};

        $columns = DB::select("DESCRIBE $tableName");
        $foreignKeyColumns = [];

        foreach ($columns as $column) {
            if (str_contains($column->Field, '_id') && $column->Field !== 'id') {
                $foreignKeyColumns[] = $column->Field;
            }
        }

        if (!empty($foreignKeyColumns)) {
            echo sprintf("📋 Table: %s\n", $tableName);
            foreach ($foreignKeyColumns as $fkColumn) {
                // Check if this column has a foreign key
                $hasForeignKey = false;
                foreach ($foreignKeys as $fk) {
                    if ($fk->table_name === $tableName && $fk->column_name === $fkColumn) {
                        $hasForeignKey = true;
                        echo sprintf(
                            "   ✅ %s -> %s.%s (PROTECTED)\n",
                            $fkColumn,
                            $fk->referenced_table,
                            $fk->referenced_column
                        );
                        break;
                    }
                }

                if (!$hasForeignKey) {
                    echo sprintf("   ❌ %s (NO FOREIGN KEY - VULNERABLE!)\n", $fkColumn);
                }
            }
            echo "\n";
        }
    }

    // 5. Kiểm tra data integrity - Orders có user_id không tồn tại
    echo "5. DATA INTEGRITY CHECK:\n";
    echo str_repeat("-", 80) . "\n";

    $orphanedOrders = DB::select("
        SELECT o.id as order_id, o.user_id, o.deleted_at as order_deleted_at
        FROM orders o 
        LEFT JOIN users u ON o.user_id = u.id 
        WHERE u.id IS NULL 
        AND o.user_id IS NOT NULL
    ");

    if (empty($orphanedOrders)) {
        echo "✅ NO ORPHANED ORDERS FOUND - Data integrity is good!\n\n";
    } else {
        echo "⚠️  ORPHANED ORDERS FOUND:\n";
        foreach ($orphanedOrders as $order) {
            echo sprintf("   Order ID: %d, Missing User ID: %d\n", $order->order_id, $order->user_id);
        }
        echo "\n";
    }

    // 6. Kiểm tra soft deleted users có orders không
    echo "6. SOFT DELETED USERS WITH ORDERS:\n";
    echo str_repeat("-", 80) . "\n";

    $deletedUsersWithOrders = DB::select("
        SELECT 
            u.id as user_id, 
            u.name, 
            u.email, 
            u.deleted_at as user_deleted_at,
            COUNT(o.id) as orders_count
        FROM users u 
        JOIN orders o ON u.id = o.user_id 
        WHERE u.deleted_at IS NOT NULL
        GROUP BY u.id, u.name, u.email, u.deleted_at
    ");

    if (empty($deletedUsersWithOrders)) {
        echo "✅ NO SOFT DELETED USERS WITH ORDERS\n\n";
    } else {
        echo "📊 SOFT DELETED USERS WITH ORDERS:\n";
        foreach ($deletedUsersWithOrders as $user) {
            echo sprintf(
                "   User: %s (%s) - %d orders (deleted: %s)\n",
                $user->name,
                $user->email,
                $user->orders_count,
                $user->user_deleted_at
            );
        }
        echo "\n";
    }

    // 7. Kiểm tra các bảng order_items có foreign key chưa
    echo "7. ORDER_ITEMS FOREIGN KEY CHECK:\n";
    echo str_repeat("-", 80) . "\n";

    if (Schema::hasTable('order_items')) {
        $orderItemsColumns = DB::select("DESCRIBE order_items");
        foreach ($orderItemsColumns as $column) {
            if (str_contains($column->Field, '_id') && $column->Field !== 'id') {
                $hasForeignKey = false;
                foreach ($foreignKeys as $fk) {
                    if ($fk->table_name === 'order_items' && $fk->column_name === $column->Field) {
                        $hasForeignKey = true;
                        echo sprintf(
                            "   ✅ %s -> %s.%s (PROTECTED)\n",
                            $column->Field,
                            $fk->referenced_table,
                            $fk->referenced_column
                        );
                        break;
                    }
                }

                if (!$hasForeignKey) {
                    echo sprintf("   ❌ %s (NO FOREIGN KEY - VULNERABLE!)\n", $column->Field);
                }
            }
        }
    } else {
        echo "   ℹ️  order_items table not found\n";
    }
    echo "\n";

    // 8. Recommendations
    echo "8. SECURITY RECOMMENDATIONS:\n";
    echo str_repeat("-", 80) . "\n";

    $vulnerableColumns = [];
    foreach ($tables as $table) {
        $tableName = $table->{"Tables_in_$databaseName"};
        $columns = DB::select("DESCRIBE $tableName");

        foreach ($columns as $column) {
            if (str_contains($column->Field, '_id') && $column->Field !== 'id') {
                $hasForeignKey = false;
                foreach ($foreignKeys as $fk) {
                    if ($fk->table_name === $tableName && $fk->column_name === $column->Field) {
                        $hasForeignKey = true;
                        break;
                    }
                }

                if (!$hasForeignKey) {
                    $vulnerableColumns[] = "$tableName.$column->Field";
                }
            }
        }
    }

    if (empty($vulnerableColumns)) {
        echo "🎉 ALL FOREIGN KEY COLUMNS ARE PROTECTED!\n\n";
    } else {
        echo "⚠️  VULNERABLE COLUMNS NEED FOREIGN KEYS:\n";
        foreach ($vulnerableColumns as $vulnerable) {
            echo "   - $vulnerable\n";
        }
        echo "\n💡 Create foreign key constraints for these columns to prevent data corruption!\n\n";
    }

    echo "=== CHECK COMPLETED ===\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
