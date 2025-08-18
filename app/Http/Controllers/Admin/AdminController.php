<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{


     /** =======================
     * DASHBOARD
     * ======================= */
    public function dashboard()
    {
        // Ambil semua laporan dengan user & gambar
        $laporans = Laporan::with(['user', 'images'])->latest()->get();

        return view('admin.pages.dashboard', compact('laporans'));
    }

    /** =======================
     * LAPORAN
     * ======================= */
    public function laporanPending()
    {
        $adminId = Auth::id();

        $laporan = Laporan::where('status', 'pending')
            ->where('admin_id', $adminId) // filter hanya untuk admin ini
            ->with(['user', 'images'])
            ->latest()
            ->get();

        return view('admin.pages.components.laporan-pending', compact('laporan'));
    }

    public function show($id)
    {
        $adminId = Auth::id();

        $laporan = Laporan::with(['user', 'images'])
            ->where('id', $id)
            ->where('admin_id', $adminId)
            ->firstOrFail();

        return view('admin.pages.components.show', compact('laporan'));
    }


    public function terimaLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status'   => 'diterima',
            'admin_id' => Auth::id() // simpan admin yang aksi
        ]);

        return back()->with('success', '✅ Laporan berhasil diterima.');
    }

    public function tolakLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status'   => 'ditolak',
            'admin_id' => Auth::id() // simpan admin yang aksi
        ]);

        return back()->with('success', '❌ Laporan berhasil ditolak.');
    }


   /** =======================
     * BERITA: Tampilkan halaman upload berita beserta daftar berita
     * ======================= */
    public function index()
    {
        // Ambil semua berita terbaru
        $beritas = Berita::latest()->get();

        // Tampilkan view dengan data berita
        return view('admin.pages.components.upload-berita', compact('beritas'));
    }

    /** =======================
     * BERITA: Simpan berita baru
     * ======================= */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sumber' => 'nullable|string|max:255',
        ]);

        $berita = new Berita();
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        $berita->sumber = $request->sumber;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan gambar di storage/app/public/berita
            $file->storeAs('berita', $filename, 'public');

            $berita->gambar = $filename;
        }

        $berita->save();

        return redirect()->route('admin.upload-berita')
                         ->with('success', '📰 Berita berhasil ditambahkan.');
    }

    /** =======================
     * BERITA: Tampilkan form edit berita
     * ======================= */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.pages.konteks.edit-berita', compact('berita'));
    }

    /** =======================
     * BERITA: Update berita
     * ======================= */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sumber' => 'nullable|string|max:255',
        ]);

        $berita = Berita::findOrFail($id);
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        $berita->sumber = $request->sumber;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                Storage::disk('public')->delete('berita/' . $berita->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('berita', $filename, 'public');
            $berita->gambar = $filename;
        }

        $berita->save();

        return redirect()->route('admin.upload-berita')
                         ->with('success', '✏️ Berita berhasil diperbarui.');
    }

    /** =======================
     * BERITA: Hapus berita
     * ======================= */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus file gambar jika ada
        if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.upload-berita')
                         ->with('success', '🗑️ Berita berhasil dihapus.');
    }
}
