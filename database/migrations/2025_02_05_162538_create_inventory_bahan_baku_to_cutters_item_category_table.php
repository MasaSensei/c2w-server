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
        Schema::create('inventory_bahan_baku_to_cutters_item_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inv_cutters_material')
                ->constrained('inventory_bahan_baku_to_cutters')
                ->onDelete('cascade')
                ->name('fk_inv_cutters_material');
            $table->foreignId('id_item_category')
                ->constrained('item_categories')
                ->onDelete('cascade')
                ->name('fk_item_category');
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
        Schema::dropIfExists('inventory_bahan_baku_to_cutters_item_category');
    }
};
