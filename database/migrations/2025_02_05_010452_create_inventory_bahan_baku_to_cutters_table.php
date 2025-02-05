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
        Schema::create('inventory_bahan_baku_to_cutters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bahan_baku')->constrained('bahan_baku')->onDelete('cascade');
            $table->date('transfer_date');
            $table->text('item');
            $table->integer('total_roll')->default(0);
            $table->decimal('total_yard', 10, 2);
            $table->enum('status', ['ready', 'on_process', 'done'])->default('ready');
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
        Schema::dropIfExists('inventory_bahan_baku_to_cutters');
    }
};
