<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('order_id');
            $table->tinyInteger('user_id');
            $table->tinyInteger('product_id');
            $table->string('product_code',255);
            $table->string('product_name', 255);
            $table->string('product_size', 255);
            $table->float('product_price');
            $table->tinyInteger('product_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
}
