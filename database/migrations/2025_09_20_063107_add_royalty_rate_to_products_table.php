<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'royalty_rate')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('royalty_rate', 5, 2)->nullable()->after('price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'royalty_rate')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('royalty_rate');
            });
        }
    }
};
