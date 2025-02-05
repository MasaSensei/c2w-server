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
        Schema::create('order_bahan_baku_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order_bahan_baku')->constrained('order_bahan_baku')->onDelete('cascade');
            $table->foreignId('id_inv_cutters_material')->constrained('inventory_bahan_baku_to_cutters')->onDelete('cascade');
            $table->integer('roll')->default(0);
            $table->decimal('total_yard', 10, 2);
            $table->decimal('cost_per_yard', 8, 2);
            $table->decimal('sub_total', 12, 2);
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_bahan_baku_details');
    }
};
