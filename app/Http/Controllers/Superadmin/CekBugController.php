<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\Bug;

class CekBugController extends Controller
{
    public function index()
    {
        $bugs = Bug::orderBy('created_at', 'desc')->get();
        return view('superadmin.pages.components.cek-bug', compact('bugs'));
    }

    public function scan(Request $request)
    {
        Bug::truncate();

        // 1. APP_DEBUG aktif
        if (config('app.debug')) {
            Bug::create([
                'judul' => 'APP_DEBUG aktif',
                'deskripsi' => 'Debug mode sebaiknya dimatikan di production (.env).',
                'status' => 'Belum Diperbaiki',
            ]);
        }

        // 2. Permission folder
        $paths = ['storage', 'bootstrap/cache'];
        foreach ($paths as $path) {
            if (!File::isWritable(base_path($path))) {
                Bug::create([
                    'judul' => "Permission folder tidak sesuai: {$path}",
                    'deskripsi' => 'Folder harus writable (chmod 775 atau 777) agar Laravel berjalan baik.',
                    'status' => 'Belum Diperbaiki',
                ]);
            }
        }

        // 3. Folder .git tersedia
        if (is_dir(base_path('.git'))) {
            Bug::create([
                'judul' => 'Folder .git tersedia',
                'deskripsi' => 'Folder .git sebaiknya dihapus atau tidak boleh diakses publik.',
                'status' => 'Belum Diperbaiki',
            ]);
        }

        // 4. File penting tersedia di public
        $publicFiles = ['.env', 'composer.lock', 'readme.md'];
        foreach ($publicFiles as $file) {
            if (file_exists(public_path($file))) {
                Bug::create([
                    'judul' => "File $file tersedia di public",
                    'deskripsi' => "File ini sensitif dan sebaiknya tidak ada di folder public.",
                    'status' => 'Belum Diperbaiki',
                ]);
            }
        }

        // 5. File phpinfo
        if (file_exists(public_path('phpinfo.php')) || file_exists(public_path('info.php'))) {
            Bug::create([
                'judul' => 'File phpinfo.php tersedia',
                'deskripsi' => 'Segera hapus file phpinfo.php atau info.php dari public path.',
                'status' => 'Belum Diperbaiki',
            ]);
        }

        // 6. File backup di public
        $backupFiles = ['backup.zip', 'db.sql', 'laravel.zip'];
        foreach ($backupFiles as $backup) {
            if (file_exists(public_path($backup))) {
                Bug::create([
                    'judul' => "File backup ditemukan: $backup",
                    'deskripsi' => "Hapus file backup dari folder public untuk keamanan.",
                    'status' => 'Belum Diperbaiki',
                ]);
            }
        }

        // 7. Folder storage di public
        if (is_dir(public_path('storage'))) {
            Bug::create([
                'judul' => 'Folder storage tersedia di public',
                'deskripsi' => 'Jangan taruh storage di dalam public path. Bisa bocor data log, session, dll.',
                'status' => 'Belum Diperbaiki',
            ]);
        }

        if (!File::exists(base_path('bootstrap/cache/config.php'))) {
    Bug::create([
        'judul' => 'Konfigurasi belum dicache',
        'deskripsi' => 'Jalankan php artisan config:cache untuk keamanan & performa.',
        'status' => 'Belum Diperbaiki',
    ]);
}

    // 9. File .DS_Store ditemukan
    if (file_exists(public_path('.DS_Store'))) {
        Bug::create([
            'judul' => 'File .DS_Store ditemukan',
            'deskripsi' => 'Hapus file ini, tidak berguna dan bisa bocor ke publik.',
            'status' => 'Belum Diperbaiki',
        ]);
    }

    // 10. File .htaccess hilang
    if (!file_exists(public_path('.htaccess'))) {
        Bug::create([
            'judul' => 'File .htaccess tidak ditemukan',
            'deskripsi' => 'File .htaccess penting untuk mengatur akses keamanan di public/.',
            'status' => 'Belum Diperbaiki',
        ]);
    }

    // 11. routes/web.php terlalu besar (>100KB)
    if (filesize(base_path('routes/web.php')) > 100000) {
        Bug::create([
            'judul' => 'routes/web.php terlalu besar',
            'deskripsi' => 'Kemungkinan disusupi shell/backdoor jika terlalu besar.',
            'status' => 'Belum Diperbaiki',
        ]);
    }

    // 12. Folder tests masih tersedia
    if (is_dir(base_path('tests'))) {
        Bug::create([
            'judul' => 'Folder tests masih tersedia',
            'deskripsi' => 'Folder tests sebaiknya dihapus di production.',
            'status' => 'Belum Diperbaiki',
        ]);
    }

    // 13. File .sql atau .bak selain backup.zip
    $files = File::files(public_path());
    foreach ($files as $file) {
        if (preg_match('/\.(sql|bak)$/', $file->getFilename()) && !in_array($file->getFilename(), ['backup.zip'])) {
            Bug::create([
                'judul' => "File backup sensitif: " . $file->getFilename(),
                'deskripsi' => 'File ini bisa bocorkan database, segera hapus.',
                'status' => 'Belum Diperbaiki',
            ]);
          }
       }
        return redirect()->route('superadmin.cek-bug')->with('success', 'Scan bug selesai.');
    }

    public function fix($id)
    {
        $bug = Bug::findOrFail($id);

        switch ($bug->judul) {
            case 'APP_DEBUG aktif':
                $envPath = base_path('.env');
                if (File::exists($envPath)) {
                    $content = File::get($envPath);
                    $content = preg_replace('/APP_DEBUG=true/', 'APP_DEBUG=false', $content);
                    File::put($envPath, $content);
                    Artisan::call('config:clear');
                    $bug->update(['status' => 'Sudah Diperbaiki']);
                }
                break;

            case 'Folder .git tersedia':
                File::deleteDirectory(base_path('.git'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File .env tersedia di public':
                File::delete(public_path('.env'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File composer.lock tersedia di public':
                File::delete(public_path('composer.lock'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File readme.md tersedia di public':
                File::delete(public_path('readme.md'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File phpinfo.php tersedia':
                File::delete(public_path('phpinfo.php'));
                File::delete(public_path('info.php'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File backup ditemukan: backup.zip':
                File::delete(public_path('backup.zip'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File backup ditemukan: db.sql':
                File::delete(public_path('db.sql'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'File backup ditemukan: laravel.zip':
                File::delete(public_path('laravel.zip'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;

            case 'Folder storage tersedia di public':
                File::deleteDirectory(public_path('storage'));
                $bug->update(['status' => 'Sudah Diperbaiki']);
                break;
        }

        return redirect()->route('superadmin.cek-bug')->with('success', 'Bug telah diperbaiki.');
    }
}
