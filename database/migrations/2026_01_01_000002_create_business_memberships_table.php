<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role', 30)->default('staff'); // owner, admin, accountant, staff
            $table->boolean('is_owner')->default(false);
            $table->string('status', 20)->default('active'); // active, invited, suspended
            $table->json('permissions')->nullable();
            $table->timestamps();

            $table->unique(['business_id', 'user_id']);
            $table->index(['business_id', 'role']);
            $table->index(['business_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_memberships');
    }
};
