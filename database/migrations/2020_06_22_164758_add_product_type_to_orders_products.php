<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductTypeToOrdersproducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('orders_products', function (Blueprint $table) {
        if (!Schema::hasColumn('orders_products', 'product_type')) {
            $table->string('product_type');
        }
        // guard any other added columns in this file the same way
    });
}

public function down()
{
    Schema::table('orders_products', function (Blueprint $table) {
        if (Schema::hasColumn('orders_products', 'product_type')) {
            $table->dropColumn('product_type');
        }
        // guard any other drops the same way
    });
}
}
