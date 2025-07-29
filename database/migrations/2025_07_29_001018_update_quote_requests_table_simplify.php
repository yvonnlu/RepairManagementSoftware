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
        Schema::table('quote_requests', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['converted_order_id']);
            
            // Rename admin_notes to notes
            $table->renameColumn('admin_notes', 'notes');
            
            // Drop columns we don't need
            $table->dropColumn(['quoted_price', 'converted_order_id']);
            
            // Update status enum to simplified values
            $table->dropColumn('status');
        });
        
        // Add back status column with new enum values
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'quoted', 'completed', 'rejected'])->default('pending')->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('notes', 'admin_notes');
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->foreignId('converted_order_id')->nullable()->constrained('orders')->onDelete('set null');
            
            // Restore original status enum
            $table->dropColumn('status');
        });
        
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'quoted', 'converted', 'rejected'])->default('pending')->after('message');
        });
    }
};
