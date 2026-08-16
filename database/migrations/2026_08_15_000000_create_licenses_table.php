<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('product_name')->default('BankCore');
            $table->string('domain')->nullable();
            $table->json('allowed_domains')->nullable();
            $table->string('status')->default('active');
            $table->unsignedInteger('max_activations')->default(1);
            $table->unsignedInteger('activation_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
