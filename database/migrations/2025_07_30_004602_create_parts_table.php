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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên part (vd: "iPhone Screen", "Laptop Battery")
            $table->string('device_type'); // smartphone, tablet, laptop, desktop, smartwatch
            $table->string('issue_category'); // Screen Replacement, Battery Replacement, etc.
            $table->text('description')->nullable(); // Mô tả chi tiết
            $table->decimal('cost_price', 10, 2)->default(0); // Giá nhập
            $table->integer('current_stock')->default(0); // Số lượng hiện tại
            $table->integer('min_stock_level')->default(1); // Mức tối thiểu để cảnh báo
            $table->string('location')->nullable(); // Vị trí lưu trữ
            $table->json('compatible_models')->nullable(); // Các model tương thích
            $table->text('notes')->nullable(); // Ghi chú
            $table->softDeletes(); // Soft delete
            $table->timestamps();

            // Index để tìm kiếm nhanh
            $table->index(['device_type', 'issue_category']);
            $table->index('current_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
