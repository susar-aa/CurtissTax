<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->unique()->constrained('businesses')->onDelete('cascade');
            $table->tinyInteger('financial_year_start_month')->default(4); // April (standard Sri Lanka)
            $table->decimal('default_tax_rate', 5, 2)->default(18.00); // 18% VAT Sri Lanka
            $table->string('invoice_prefix', 20)->default('INV-');
            $table->unsignedInteger('invoice_next_number')->default(1001);
            $table->text('invoice_footer_notes')->nullable();
            $table->text('invoice_terms')->nullable();
            $table->string('invoice_locale', 10)->default('en')->comment('Invoice language: en, si, or ta');
            $table->boolean('show_bank_details')->default(true);
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_swift_code', 30)->nullable();
            $table->timestamps();

            $table->index('business_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_settings');
    }
};
