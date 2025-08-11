<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Laporan;
use App\Models\LaporanImage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

 
    // Menampilkan form kirim laporan
    public function create($adminId)
    {
        $admin = User::findOrFail($adminId);
        return view('user.pages.kirim-laporan', compact('admin'));
    }

    // Menyimpan laporan baru
   public function store(Request $request, $adminId)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'isi'   => 'required|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = Auth::user();
    $folderName = 'Laporan_user/' . str_replace(' ', '_', strtolower($user->name)); // public/laporan_user/nama_user

    // Buat laporan
    $laporan = Laporan::create([
        'user_id'  => $user->id,
        'admin_id' => $adminId,
        'judul'    => $request->judul,
        'isi'      => $request->isi,
        'status'   => 'pending'
    ]);

    // Simpan gambar jika ada
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $filename = time() . '_' . preg_replace('/\s+/', '_', $img->getClientOriginalName());
            $img->move(public_path($folderName), $filename); // Simpan langsung ke /public

                    LaporanImage::create([
                'laporan_id' => $laporan->id,
                'filename'   => 'Laporan_user/' . str_replace(' ', '_', strtolower($user->name)) . '/' . $filename
            ]);

        }
    }

    return redirect()->back()->with('success', 'Laporan berhasil dikirim.');
}

    // Menampilkan riwayat laporan user
    public function riwayat()
    {
        $laporans = Laporan::with(['adminTujuan', 'images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.pages.konteks.riwayat-laporan', compact('laporans'));
    }

    // Detail laporan
    public function detail($id)
    {
        $laporan = Laporan::with('adminTujuan')->findOrFail($id);

        // Pastikan laporan milik user yang sedang login
        if ($laporan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.pages.konteks.detail-laporan', compact('laporan'));
    }
}
