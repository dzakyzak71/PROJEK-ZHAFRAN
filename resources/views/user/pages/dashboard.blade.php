@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-8">📊 Dashboard User</h1>

    {{-- Info Box --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Laporan Anda</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalLaporan }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Menunggu Verifikasi</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $laporanPending }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Laporan Disetujui</h2>
            <p class="text-3xl font-bold text-green-600">{{ $laporanDisetujui }}</p>
        </div>
    </div>

    {{-- Recent Reports --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">📄 Laporan Terbaru</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($recentLaporan as $laporan)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $laporan->judul }}</td>
                    <td class="px-4 py-3">
                        @if($laporan->status == 'pending')
                            <span class="text-yellow-500 font-semibold">⏳ Pending</span>
                        @elseif($laporan->status == 'disetujui')
                            <span class="text-green-600 font-semibold">✅ Disetujui</span>
                        @else
                            <span class="text-red-600 font-semibold">❌ Ditolak</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $laporan->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
