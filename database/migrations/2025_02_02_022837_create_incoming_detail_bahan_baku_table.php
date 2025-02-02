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
        Schema::create('incoming_detail_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_incoming_bahan_baku')->constrained('incoming_bahan_baku')->onDelete('cascade');
            $table->foreignId('id_bahan_baku')->constrained('bahan_baku')->onDelete('cascade');
            $table->decimal('length_yard', 8, 2)->nullable();
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
        Schema::dropIfExists('incoming_detail_bahan_baku');
    }
};
