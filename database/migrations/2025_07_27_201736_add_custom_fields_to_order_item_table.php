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
        Schema::table('order_item', function (Blueprint $table) {
            // Add custom fields for custom quote functionality
            $table->text('custom_description')->nullable()->after('price');
            $table->string('custom_device_type')->nullable()->after('custom_description');
            $table->string('custom_issue_category')->nullable()->after('custom_device_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_item', function (Blueprint $table) {
            // Drop the custom fields in reverse order
            $table->dropColumn([
                'custom_issue_category',
                'custom_device_type',
                'custom_description'
            ]);
        });
    }
};
