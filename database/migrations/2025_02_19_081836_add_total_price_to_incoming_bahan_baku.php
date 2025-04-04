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
        Schema::table('incoming_bahan_baku', function (Blueprint $table) {
            $table->decimal('total_price', 12, 2)->default(0)->after('invoice_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_bahan_baku', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
