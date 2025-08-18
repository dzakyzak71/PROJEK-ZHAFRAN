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

            // Identitas dasar
            $table->string('username')->unique();   // username untuk login
            $table->string('name')->nullable();     // nama lengkap
            $table->string('email')->unique();      // Gmail wajib
            $table->string('phone')->nullable();    // nomor telepon

            // Keamanan & Verifikasi
            $table->string('password')->nullable(); // password, bisa kosong kalau pakai OTP
            $table->string('otp')->nullable();      // kode OTP
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_verified')->default(false); // status verifikasi Gmail/OTP

            // Tracking
            $table->string('ip')->nullable();
            $table->string('location')->nullable();

            // Laravel default
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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