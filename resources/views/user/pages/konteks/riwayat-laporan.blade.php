@extends('layouts.user')

@section('title', 'Riwayat Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Riwayat Laporan</h1>

@forelse ($laporans as $laporan)
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="text-lg font-semibold">{{ $laporan->judul }}</h2>
        <p class="text-sm text-gray-600">Kepada: {{ $laporan->adminTujuan->name }}</p>
        <p class="mt-2">{{ Str::limit($laporan->isi, 100) }}</p>
        <a href="{{ route('user.laporan.detail', $laporan->id) }}" class="text-blue-500 hover:underline mt-2 inline-block">
            Lihat Detail
        </a>
    </div>
@empty
    <p class="text-gray-600">Belum ada laporan yang dikirim.</p>
@endforelse
@endsection
