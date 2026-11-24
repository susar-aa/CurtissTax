<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_lkr_monthly', 10, 2)->default(0.00);
            $table->decimal('price_lkr_annually', 10, 2)->default(0.00);
            $table->integer('max_users')->default(1);
            $table->integer('max_invoices_per_month')->default(50);
            $table->integer('max_branches')->default(1);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};
