<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil berita terbaru
        $beritas = Berita::latest()->take(6)->get();

        // Dummy data statistik pengunjung harian
        $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $data = [120, 180, 150, 200, 300, 250, 400]; // bisa diganti dari DB

        return view('home.index', compact('beritas', 'labels', 'data'));
    }
}
