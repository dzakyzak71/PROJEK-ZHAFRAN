<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

        public function up(): void
    {
        Schema::table('laporan_images', function (Blueprint $table) {
            $table->string('filename')->after('laporan_id');
             $table->dropColumn('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_images', function (Blueprint $table) {
            $table->dropColumn('filename');
             $table->string('image_path')->nullable();
        });
    }

};
