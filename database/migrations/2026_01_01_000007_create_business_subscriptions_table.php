<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('restrict');
            $table->string('billing_cycle', 20)->default('monthly'); // monthly, annually
            $table->string('status', 20)->default('trial'); // trial, active, past_due, canceled, expired
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->string('payment_method', 50)->nullable();
            $table->text('reference_note')->nullable();
            $table->timestamps();

            $table->index('business_id');
            $table->index('plan_id');
            $table->index('status');
            $table->index(['business_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_subscriptions');
    }
};
