<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEbookToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'book_path')) {
            $table->string('book_path');
        }
        // If this migration also adds other columns (e.g., is_ebook, ebook_price, etc.),
        // guard them too. Example:
        if (!Schema::hasColumn('products', 'is_ebook')) {
            $table->boolean('is_ebook')->default(false);
        }
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'book_path')) {
            $table->dropColumn('book_path');
        }
        if (Schema::hasColumn('products', 'is_ebook')) {
            $table->dropColumn('is_ebook');
        }
       });
    }
}
