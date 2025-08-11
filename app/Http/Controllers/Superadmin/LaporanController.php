<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan sudah pakai package dompdf

class LaporanController extends Controller
{
    /**
     * Menampilkan semua laporan dari user.
     */
    public function index()
    {
        // Ambil laporan + relasi user dan images
        $laporans = Laporan::with(['user', 'images'])->latest()->get();

        return view('superadmin.pages.components.laporan-user', compact('laporans'));
    }

    /**
     * Menampilkan detail laporan tertentu.
     */
    public function show($id)
    {
        $laporan = Laporan::with(['user', 'images'])->findOrFail($id);

        return view('superadmin.pages.konteks.detail', compact('laporan'));
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf($id)
    {
        $laporan = Laporan::with(['user', 'images'])->findOrFail($id);

        $pdf = Pdf::loadView('superadmin.pages.konteks.pdf', compact('laporan'));
        
        return $pdf->download('laporan_user_' . $laporan->id . '.pdf');
    }

    /**
     * Menampilkan tampilan cetak laporan.
     */
    public function print($id)
    {
        $laporan = Laporan::with(['user', 'images'])->findOrFail($id);

        return view('superadmin.pages.konteks.print', compact('laporan'));
    }
}
