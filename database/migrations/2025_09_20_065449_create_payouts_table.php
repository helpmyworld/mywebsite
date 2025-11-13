<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payouts', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('author_id')->index();
            $t->string('period_label'); // e.g. 2025-Q3 or 2025-YTD
            $t->date('from_date');
            $t->date('to_date');
            $t->decimal('amount', 12, 2);     // ZAR royalty to pay
            $t->string('status')->default('pending'); // pending|scheduled|paid|failed
            $t->string('reference')->nullable();      // payment reference
            $t->string('proof_path')->nullable();     // admin uploaded proof
            $t->text('notes')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payouts'); }
};
