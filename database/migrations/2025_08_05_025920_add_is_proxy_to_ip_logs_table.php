<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah pengecekan agar tidak error jika kolom sudah ada
        if (!Schema::hasColumn('ip_logs', 'is_proxy')) {
            Schema::table('ip_logs', function (Blueprint $table) {
                $table->boolean('is_proxy')->default(false)->after('lon');
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom hanya jika ada
        if (Schema::hasColumn('ip_logs', 'is_proxy')) {
            Schema::table('ip_logs', function (Blueprint $table) {
                $table->dropColumn('is_proxy');
            });
        }
    }
};
