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
        Schema::create('batch_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_batch')->constrained('batches')->onDelete('cascade');
            $table->text('product_code');
            $table->enum('reference_type', ['cutters', 'sewer', 'client'])->default('cutters');
            $table->integer('quantity');
            $table->decimal('total_yard', 10, 2);
            $table->decimal('cost_per_yard', 8, 2);
            $table->decimal('sub_total', 12, 2);
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['reference_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_details');
    }
};
