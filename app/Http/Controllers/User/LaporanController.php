<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laporan;

class LaporanController extends Controller
{
    // Form Kirim Laporan
    public function create(User $admin)
    {
        return view('user.pages.kirim-laporan', compact('admin'));
    }

    // Simpan Laporan
    public function store(Request $request, User $admin)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Laporan::create([
            'user_id' => Auth::id(),
            'admin_id' => $admin->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return redirect()->route('user.laporan.riwayat')->with('success', 'Laporan berhasil dikirim!');
    }

    // Riwayat Laporan
    public function riwayat()
    {
        $laporans = Laporan::with('adminTujuan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.pages.konteks.riwayat-laporan', compact('laporans'));
    }

    // Detail Laporan
    public function detail(Laporan $laporan)
    {
        if ($laporan->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.pages.konteks.detail-laporan', compact('laporan'));
    }
}
