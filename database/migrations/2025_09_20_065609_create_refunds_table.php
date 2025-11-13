<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('refunds', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('order_id')->index();
            $t->unsignedBigInteger('order_product_id')->nullable()->index(); // line level if applicable
            $t->decimal('amount', 12, 2); // ZAR refunded
            $t->integer('units')->default(0); // units reversed for reports
            $t->string('reason')->nullable();
            $t->timestamp('refunded_at')->nullable()->index();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('refunds'); }
};
