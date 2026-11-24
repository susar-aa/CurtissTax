<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('registration_number', 50)->nullable();
            $table->string('tin', 50)->nullable()->comment('Taxpayer Identification Number');
            $table->string('vat_number', 50)->nullable()->comment('VAT Registration Number');
            $table->boolean('is_vat_registered')->default(false);
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('country', 10)->default('LK');
            $table->string('currency', 10)->default('LKR');
            $table->string('logo_path')->nullable();
            $table->string('vat_cert_path')->nullable();
            $table->string('status', 20)->default('active')->index();
            $table->dateTime('trial_starts_at')->nullable();
            $table->dateTime('trial_ends_at')->nullable()->index();
            $table->string('subscription_status', 20)->default('trial')->index();
            $table->unsignedBigInteger('current_plan_id')->nullable()->index();
            $table->unsignedBigInteger('created_by_user_id')->nullable()->index();
            $table->timestamps();

            $table->index(['status', 'subscription_status']);
            $table->index(['id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
