<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrdersPeoductAddDownloadLinkToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('orders_products', function (Blueprint $table) {
        if (!Schema::hasColumn('orders_products', 'download_link_token')) {
            $table->text('download_link_token')->nullable();
        }
        if (!Schema::hasColumn('orders_products', 'is_link_expired')) {
            $table->boolean('is_link_expired')->default(false);
        }
    });
}

public function down()
{
    Schema::table('orders_products', function (Blueprint $table) {
        if (Schema::hasColumn('orders_products', 'download_link_token')) {
            $table->dropColumn('download_link_token');
        }
        if (Schema::hasColumn('orders_products', 'is_link_expired')) {
            $table->dropColumn('is_link_expired');
        }
    });
}
}
