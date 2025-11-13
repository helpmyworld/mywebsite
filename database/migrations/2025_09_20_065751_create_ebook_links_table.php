<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ebook_links', function (Blueprint $t) {
            $t->id();
            $t->string('token', 64)->unique();     // download token
            $t->unsignedBigInteger('order_id')->index();
            $t->unsignedBigInteger('order_product_id')->nullable()->index();
            $t->unsignedBigInteger('product_id')->index();
            $t->unsignedBigInteger('buyer_id')->nullable()->index();
            $t->string('file_path');               // storage path to e-book at creation time
            $t->integer('max_attempts')->default(config('ebooks.max_attempts',5));
            $t->integer('attempts')->default(0);
            $t->timestamp('expires_at')->index();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ebook_links'); }
};
