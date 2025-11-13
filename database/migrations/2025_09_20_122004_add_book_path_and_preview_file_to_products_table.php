<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns if they are missing
        if (!Schema::hasColumn('products', 'book_path') || !Schema::hasColumn('products', 'preview_file')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'book_path')) {
                    // place after 'image' if that column exists; otherwise it just appends
                    $table->string('book_path')->nullable()->after('image');
                }
                if (!Schema::hasColumn('products', 'preview_file')) {
                    $table->string('preview_file')->nullable()->after('book_path');
                }
            });
        }
    }

    public function down(): void
    {
        // Drop only if present
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'preview_file')) {
                $table->dropColumn('preview_file');
            }
            if (Schema::hasColumn('products', 'book_path')) {
                $table->dropColumn('book_path');
            }
        });
    }
};
