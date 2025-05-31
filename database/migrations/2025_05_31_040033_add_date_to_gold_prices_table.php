<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gold_prices', function (Blueprint $table) {
            $table->date('date')->after('sell_price');
        });
    }

    public function down(): void
    {
        Schema::table('gold_prices', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}; 