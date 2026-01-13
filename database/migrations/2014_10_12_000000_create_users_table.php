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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('address')->nullable();


            $table->string('otp')->nullable();
            $table->string('lang')->default('ar')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('last_login')->nullable();
            $table->timestamp('otp_expires_at')->nullable();


            $table->timestamp('phone_verified_at')->nullable();
            $table->rememberToken();



            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
