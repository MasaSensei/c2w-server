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
        Schema::create('material_worker_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_worker')->constrained('workers')->onDelete('cascade');
            $table->foreignId('id_worker_type')->constrained('worker_types')->onDelete('cascade');
            $table->foreignId('id_item_category')->constrained('item_categories')->onDelete('cascade');
            $table->decimal('min_cost', 10, 2);
            $table->decimal('cost_per_yard', 10, 2);
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
        Schema::dropIfExists('material_worker_prices');
    }
};
