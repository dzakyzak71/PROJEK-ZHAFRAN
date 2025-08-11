<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Simpan data pengunjung tiap akses halaman home
        $ip = $request->ip();
        Visitor::create([
            'ip_address' => $ip,
            'visited_at' => now(),
        ]);

        // Ambil 6 berita terbaru
        $beritas = Berita::latest()->take(6)->get();

        // Hitung statistik pengunjung mingguan (7 hari terakhir)
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $visitorData = Visitor::select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(DISTINCT ip_address) as count')
            )
            ->whereBetween('visited_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $labels[] = $date->format('D, d M');  // Contoh: Sen, 07 Agu
            $data[] = $visitorData[$date->toDateString()]->count ?? 0;
        }

        return view('home.index', compact('beritas', 'labels', 'data'));
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('home.show', compact('berita'));
    }
}
