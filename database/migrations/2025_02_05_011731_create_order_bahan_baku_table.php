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
        Schema::create('order_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('order_date');
            $table->date('due_date');
            $table->enum('status', ['new', 'pending', 'done'])->default('new');
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
        Schema::dropIfExists('order_bahan_baku');
    }
};
