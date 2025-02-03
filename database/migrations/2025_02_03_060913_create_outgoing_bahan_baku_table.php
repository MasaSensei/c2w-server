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
        Schema::create('outgoing_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bahan_baku')->constrained('bahan_baku')->onDelete('cascade');
            $table->date('outgoing_date');
            $table->integer('total_roll');
            $table->decimal('total_yard', 8, 2);
            $table->enum('status', ['cutting', 'return'])->default('cutting');
            $table->string('incoming_invoice_number')->nullable();
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
        Schema::dropIfExists('outgoing_bahan_baku');
    }
};
