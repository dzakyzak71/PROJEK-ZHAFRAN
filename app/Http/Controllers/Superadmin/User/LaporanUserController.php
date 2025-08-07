<?php
namespace App\Http\Controllers\Superadmin\User;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class LaporanUserController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with('user')->latest()->get();
        return view('superadmin.pages.user.laporan-user', compact('laporans'));
    }
}
