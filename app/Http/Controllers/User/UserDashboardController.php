<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalLaporan = Laporan::where('user_id', $userId)->count();
        $laporanPending = Laporan::where('user_id', $userId)->where('status', 'pending')->count();
        $laporanDisetujui = Laporan::where('user_id', $userId)->where('status', 'disetujui')->count();

        $recentLaporan = Laporan::where('user_id', $userId)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('user.pages.dashboard', compact(
            'totalLaporan',
            'laporanPending',
            'laporanDisetujui',
            'recentLaporan'
        ));
    }
}
