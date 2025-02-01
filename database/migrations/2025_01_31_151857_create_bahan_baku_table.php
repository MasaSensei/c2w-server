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
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_code')->constrained('code')->onDelete('cascade');
            $table->foreignId('id_color')->constrained('color')->onDelete('cascade');
            $table->text('item');
            $table->integer('total_roll')->default(0)->nullable();
            $table->decimal('total_yard', 8, 2)->nullable();
            $table->decimal('cost_per_yard', 8, 2)->nullable();
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
        Schema::dropIfExists('bahan_baku');
    }
};
