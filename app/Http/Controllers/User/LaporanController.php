<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanImage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function create()
    {
        $admins = User::role('admin')->get(); // pakai spatie role
        return view('user.pages.components.create', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string|max:2000',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan laporan utama
        $laporan = Laporan::create([
            'user_id' => Auth::id(),
            'admin_id' => $request->admin_id,
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
        ]);

        // Simpan gambar-gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $img) {
                $path = $img->store('laporan/gambar');
                LaporanImage::create([
                    'laporan_id' => $laporan->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }
}
