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
         Schema::create('ip_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('ip');
        $table->string('city')->nullable();
        $table->string('region')->nullable();
        $table->string('country')->nullable();
        $table->string('lat')->nullable();
        $table->string('lon')->nullable();
        $table->string('location')->nullable(); // Tambahkan jika belum ada
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_logs');
    }
};
