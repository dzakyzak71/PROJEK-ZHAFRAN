<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bug;

class BugSeeder extends Seeder
{
    public function run(): void
    {
        Bug::truncate();

        $bugs = [
            [
                'judul' => 'APP_DEBUG aktif',
                'deskripsi' => 'Debug mode aktif, bisa bocor data error.',
                'status' => 'Belum Diperbaiki',
            ],
            [
                'judul' => 'File phpinfo.php tersedia',
                'deskripsi' => 'Harus dihapus dari public untuk keamanan.',
                'status' => 'Belum Diperbaiki',
            ],
            [
                'judul' => 'File backup ditemukan: db.sql',
                'deskripsi' => 'File ini bisa bocorkan database.',
                'status' => 'Belum Diperbaiki',
            ],
        ];

        foreach ($bugs as $bug) {
            Bug::create($bug);
        }
    }
}
