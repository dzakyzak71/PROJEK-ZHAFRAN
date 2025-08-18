<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;



class UserAdminController extends Controller
{
    //usercard
    public function index()
    {
        // Hanya ambil user dengan role 'user'
        $laporans = Laporan::with(['user', 'images'])->latest()->get();
        $users = User::role('user')->get();
        return view('admin.pages.components.usercard', compact('users'));
    }

    // Detail laporan milik user (hanya status diterima atau ditolak)
    public function laporanUserDetail($id)
    {
        $user = User::findOrFail($id);
        $laporans = Laporan::with(['user', 'images'])->latest()->get();

        // Ambil laporan hanya yang statusnya diterima atau ditolak
        $laporans = Laporan::where('user_id', $id)
            ->whereIn('status', ['diterima', 'ditolak'])
            ->with(['user', 'images'])
            ->latest()
            ->get();

        return view('admin.pages.components.detail-laporan-user', compact('user', 'laporans'));
    }

            public function show($id)
        {
            $laporan = Laporan::where('id', $id)
                ->whereIn('status', ['diterima', 'ditolak'])
                ->firstOrFail();

            // Redirect balik ke detail laporan user yang bersangkutan
            return redirect()->route('admin.pages.components.detail-laporan-user', $laporan->user_id);
        }

    /**
     * Cetak laporan ke PDF.
     */
   public function cetakPdf($userId)
    {
        // Ambil data user
        $user = User::findOrFail($userId);

        // Ambil semua laporan user beserta relasi images
        $laporan = Laporan::with('images')
            ->where('user_id', $user->id)
            ->whereIn('status', ['diterima', 'ditolak'])
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('admin.pages.konteks.pdf', compact('user','laporan'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-user-'.$user->id.'.pdf');
    }



    /**
     * Hapus laporan.
     */
 public function destroy($id)
{
    $laporan = Laporan::where('id', $id)
        ->whereIn('status', ['diterima', 'ditolak'])
        ->with('images') // ambil data gambar terkait
        ->firstOrFail();

    // Hapus gambar di folder public
    if ($laporan->images) {
        foreach ($laporan->images as $image) {
            $path = public_path($image->filename); // langsung dari kolom filename
            if (file_exists($path)) {
                unlink($path);
            }
            // hapus record gambar di database
            $image->delete();
        }
    }

    // Hapus laporan
    $laporan->delete();

    return redirect()->back()->with('success', 'Laporan dan gambarnya berhasil dihapus.');
}


}
