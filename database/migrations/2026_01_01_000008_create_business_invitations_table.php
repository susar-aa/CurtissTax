<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('email');
            $table->string('role', 30)->default('staff');
            $table->string('token', 64)->unique();
            $table->foreignId('invited_by_user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('expires_at');
            $table->dateTime('accepted_at')->nullable();
            $table->timestamps();

            $table->index(['business_id', 'email']);
            $table->index('expires_at');
            $table->index('token');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_invitations');
    }
};
