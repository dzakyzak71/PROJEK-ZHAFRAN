<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
     $laporans = Laporan::latest()->get();
        return view('superadmin.pages.components.laporan-user', compact('laporans'));
    }
 // Menampilkan detail laporan
    public function show($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('superadmin.pages.konteks.detail', compact('laporan'));
    }

    // Export PDF
    public function exportPdf($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('superadmin.pages.konteks.pdf', compact('laporan'));
        return $pdf->download('laporan_user_' . $laporan->id . '.pdf');
    }

    // Tampilan cetak
    public function print($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('superadmin.pages.konteks.print', compact('laporan'));
    }
}
