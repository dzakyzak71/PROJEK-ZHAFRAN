@extends('layouts.superadmin')

@section('title', 'Tracking IP Hacker')

@section('content')
<h1 class="text-2xl font-bold mb-4">🛰️ Tracking IP Pengguna</h1>

<!-- Filter user -->
<form method="GET" action="{{ route('superadmin.tracking') }}" class="mb-6">
    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-700">Filter berdasarkan user:</label>
    <div class="flex items-center gap-2">
        <select name="user_id" id="user_id" class="w-full p-2 border border-gray-300 rounded" onchange="this.form.submit()">
            <option value="">-- Semua User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        @if(request('user_id'))
            <a href="{{ route('superadmin.tracking') }}" class="text-sm px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Reset</a>
        @endif
    </div>
</form>

<!-- Tombol Ekspor dan Hapus -->
<div class="flex flex-wrap gap-3 mb-4">
    <a href="{{ route('superadmin.tracking.export') }}"
       class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        📤 Ekspor Excel
    </a>

    <form method="POST" action="{{ route('superadmin.tracking.clearOldLogs') }}"
          onsubmit="return confirm('Yakin ingin menghapus log lebih dari 30 hari?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            🧹 Hapus Log Lama
        </button>
    </form>
</div>

<!-- Tabel Log IP -->
<table class="w-full table-auto bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">IP Address</th>
            <th class="px-4 py-2">Lokasi</th>
            <th class="px-4 py-2">VPN / Proxy</th>
            <th class="px-4 py-2">Waktu</th>
            <th class="px-4 py-2">Maps</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ipLogs as $log)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $log->user->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $log->ip_address }}</td>
                <td class="px-4 py-2">
                    {{ $log->city ?? '' }}, {{ $log->region ?? '' }}, {{ $log->country ?? '' }}
                </td>
                <td class="px-4 py-2">
                    @if($log->is_vpn)
                        <span class="text-red-600 font-semibold">✅ Ya</span>
                    @else
                        <span class="text-green-600">❌ Tidak</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                <td class="px-4 py-2">
                    @if($log->lat && $log->lon)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $log->lat }},{{ $log->lon }}" target="_blank" class="text-blue-600 hover:underline">
                            📍 Lihat
                        </a>
                    @else
                        <span class="text-gray-400">Tidak tersedia</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-4 text-center text-gray-500">Tidak ada data IP.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Map Langsung -->
@if($ipLogs->count())
    <div id="map" class="my-6 w-full rounded shadow border" style="height: 500px;"></div>
@endif
@endsection

@section('scripts')
<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($ipLogs->count())
            var map = L.map('map').setView([-2.5489, 118.0149], 5); // Fokus awal: Indonesia

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            @foreach($ipLogs as $log)
                @if($log->lat && $log->lon)
                    L.marker([{{ $log->lat }}, {{ $log->lon }}]).addTo(map)
                        .bindPopup(`
                            <strong>{{ $log->user->name ?? 'Tidak diketahui' }}</strong><br>
                            IP: {{ $log->ip_address }}<br>
                            VPN: {{ $log->is_vpn ? 'Ya' : 'Tidak' }}<br>
                            {{ $log->city }}, {{ $log->region }}, {{ $log->country }}<br>
                            Waktu: {{ $log->created_at->format('d-m-Y H:i') }}
                        `);
                @endif
            @endforeach
        @endif
    });
</script>
@endsection
