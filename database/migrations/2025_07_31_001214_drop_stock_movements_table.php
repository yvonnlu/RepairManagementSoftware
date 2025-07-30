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
        Schema::dropIfExists('stock_movements');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('parts')->onDelete('cascade');
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->string('reason');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['part_id', 'type']);
            $table->index('order_id');
        });
    }
};
