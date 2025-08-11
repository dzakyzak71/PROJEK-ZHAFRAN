<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                  ->constrained('laporans')
                  ->onDelete('cascade');
            $table->string('image_path'); // Simpan path relatif seperti Laporan_user/namauser/namafile.jpg
           // database/migrations/xxxx_xx_xx_create_laporans_table.php
            $table->enum('status', ['pending', 'diterima'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_images');
    }
};
