<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // user yang membuat laporan
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // admin tujuan laporan (nullable supaya kalau belum ditugaskan tidak error)
            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // judul & isi laporan
            $table->string('judul', 255);
            $table->longText('isi');

            // status laporan (pending, diproses, selesai)
            $table->enum('status', ['pending', 'diproses', 'selesai'])
                  ->default('pending');

            // tracking IP dan lokasi
            $table->string('ip_address', 45)->nullable();
            $table->string('lokasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
