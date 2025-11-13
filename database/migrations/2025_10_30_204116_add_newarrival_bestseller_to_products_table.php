<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_new_arrival')) {
                $table->tinyInteger('is_new_arrival')->default(0)->after('is_featured');
            }
            if (!Schema::hasColumn('products', 'is_best_seller')) {
                $table->tinyInteger('is_best_seller')->default(0)->after('is_new_arrival');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_new_arrival')) {
                $table->dropColumn('is_new_arrival');
            }
            if (Schema::hasColumn('products', 'is_best_seller')) {
                $table->dropColumn('is_best_seller');
            }
        });
    }
};
