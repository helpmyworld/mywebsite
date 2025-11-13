<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_special_offer')) {
                $table->boolean('is_special_offer')
                      ->default(0)
                      ->after('is_best_seller')
                      ->comment('Marks product as special offer');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_special_offer')) {
                $table->dropColumn('is_special_offer');
            }
        });
    }
};
