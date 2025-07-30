<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parts', function (Blueprint $table) {
            // Movement tracking columns
            $table->integer('total_in')->default(0)->after('current_stock'); // Tổng số nhập
            $table->integer('total_out')->default(0)->after('total_in'); // Tổng số xuất
            $table->timestamp('last_movement_date')->nullable()->after('total_out'); // Ngày movement cuối
            $table->enum('last_movement_type', ['in', 'out'])->nullable()->after('last_movement_date'); // Loại movement cuối
            $table->string('last_movement_reason')->nullable()->after('last_movement_type'); // Lý do movement cuối
            $table->integer('last_movement_quantity')->nullable()->after('last_movement_reason'); // Số lượng movement cuối
            $table->text('last_movement_notes')->nullable()->after('last_movement_quantity'); // Ghi chú movement cuối
            $table->foreignId('last_order_id')->nullable()->constrained('orders')->onDelete('set null')->after('last_movement_notes'); // Order liên quan đến movement cuối
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('last_order_id');
            $table->dropColumn([
                'total_in',
                'total_out', 
                'last_movement_date',
                'last_movement_type',
                'last_movement_reason',
                'last_movement_quantity',
                'last_movement_notes'
            ]);
        });
    }
};
