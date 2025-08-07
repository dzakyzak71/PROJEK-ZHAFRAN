<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class HomeController extends Controller
{
  

public function index()
{
    $beritas = Berita::latest()->take(6)->get();
     

    // Contoh data statistik dummy (ganti dengan data real jika ada)
    $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $data = [120, 150, 90, 200, 180, 130, 100];

    return view('home.index', compact('beritas', 'labels', 'data'));
}
    // Tambahkan metode lain jika diperlukan
    public function show($id)
{
    $berita = Berita::findOrFail($id);
    return view('home.show', compact('berita'));
}
}