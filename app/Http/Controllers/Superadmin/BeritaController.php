<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // Menampilkan semua berita dan form upload
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->get();
        return view('superadmin.pages.components.upload-berita', compact('beritas'));
    }

    // Simpan berita baru
    public function store(Request $request)
    {
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

        // Coba simpan dan cek hasilnya
        $path = $file->storeAs('berita', $filename, 'public');


        if (!$path || !Storage::exists('public/berita/' . $filename)) {
           
    }

         $berita->gambar = $filename;
}

        $berita->save();
        
        return redirect()->route('superadmin.upload-berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('superadmin.pages.konteks.edit-berita', compact('berita'));
    }

    // Simpan perubahan berita
    public function update(Request $request, $id)
    {
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
            if ($berita->gambar && file_exists(public_path('storage/berita/' . $berita->gambar))) {
                unlink(public_path('storage/berita/' . $berita->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berita', $filename, 'public');
            $berita->gambar = $filename;
        }

        $berita->save();

        return redirect()->route('superadmin.upload-berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // Hapus berita
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && file_exists(public_path('storage/berita/' . $berita->gambar))) {
            unlink(public_path('storage/berita/' . $berita->gambar));
        }

        $berita->delete();

    return redirect()->route('superadmin.upload-berita')->with('success', 'Berita berhasil diperbarui.');
    }
}
