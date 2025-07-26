<?php

// app/Http/Controllers/Superadmin/BeritaController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function create()
    {
        return view('superadmin.pages.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'required|image|max:2048'
        ]);

        $gambar = $request->file('gambar')->store('images', 'public');

        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => basename($gambar),
        ]);

        return redirect()->route('berita.create')->with('success', 'Berita berhasil ditambahkan.');
    }
}

