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
        Schema::create('item_category_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bahan_baku');
            $table->unsignedBigInteger('id_item_category');

            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku')->onDelete('cascade');
            $table->foreign('id_item_category')->references('id')->on('item_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_category_bahan_baku');
    }
};
