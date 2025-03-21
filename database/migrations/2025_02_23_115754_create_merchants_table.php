<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            //for CVT Verification [verification_token,verification_token_till]
            $table->string('verification_token')->nullable();
            $table->timestamp('verification_token_till')->nullable();
            //fieldes for otp
            $table->string('phone')->unique()->nullable();
            $table->string('otp')->unique()->nullable();
            $table->timestamp('otp_till')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
