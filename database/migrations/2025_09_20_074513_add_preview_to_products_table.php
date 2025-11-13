<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviewToProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Only add if it doesn't exist already
            if (!Schema::hasColumn('products', 'preview_file')) {
                // If book_path exists, place after it; otherwise just append
                if (Schema::hasColumn('products', 'book_path')) {
                    $table->string('preview_file')->nullable()->after('book_path');
                } else {
                    $table->string('preview_file')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'preview_file')) {
                $table->dropColumn('preview_file');
            }
        });
    }
}
