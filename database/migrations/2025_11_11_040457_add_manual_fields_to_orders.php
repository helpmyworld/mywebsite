<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $t) {
            if (!Schema::hasColumn('orders', 'source')) {
                $t->string('source', 20)->default('website'); // website|manual
            }
            if (!Schema::hasColumn('orders', 'platform')) {
                $t->string('platform', 50)->nullable(); // Invoice, In-store, Takealot, etc.
            }
            if (!Schema::hasColumn('orders', 'invoice_number')) {
                $t->string('invoice_number', 100)->nullable()->index();
            }
            if (!Schema::hasColumn('orders', 'order_number')) {
                $t->string('order_number', 100)->nullable()->index();
            }
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $t->timestamp('paid_at')->nullable()->index();
            }
        });
    }

    public function down(): void {
        Schema::table('orders', function (Blueprint $t) {
            if (Schema::hasColumn('orders', 'source')) $t->dropColumn('source');
            if (Schema::hasColumn('orders', 'platform')) $t->dropColumn('platform');
            if (Schema::hasColumn('orders', 'invoice_number')) $t->dropColumn('invoice_number');
            if (Schema::hasColumn('orders', 'order_number')) $t->dropColumn('order_number');
            if (Schema::hasColumn('orders', 'paid_at')) $t->dropColumn('paid_at');
        });
    }
};
