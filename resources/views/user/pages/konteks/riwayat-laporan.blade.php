@extends('layouts.user')

@section('title', 'Riwayat Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-6 text-gray-100">Riwayat Laporan</h1>

@forelse ($laporans as $laporan)
    <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-gray-700 mb-4 transition hover:shadow-xl">
        
        {{-- Judul --}}
        <h2 class="text-xl font-bold text-white">{{ $laporan->judul }}</h2>

        {{-- Admin tujuan --}}
        <p class="text-sm text-gray-400 mt-1">
            Kepada: <span class="font-medium text-gray-200">
                {{ $laporan->adminTujuan->name ?? 'Belum ditugaskan' }}
            </span>
        </p>

        {{-- Status laporan --}}
        <div class="mt-2">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-500/20 text-yellow-400',
                    'diterima' => 'bg-green-500/20 text-green-400',
                    'diproses' => 'bg-blue-500/20 text-blue-400',
                    'selesai' => 'bg-gray-500/20 text-gray-300',
                ];
            @endphp
            <span class="px-2 py-1 text-xs rounded {{ $statusColors[$laporan->status] ?? 'bg-red-500/20 text-red-400' }}">
                {{ ucfirst($laporan->status) }}
            </span>
        </div>

        {{-- Isi laporan --}}
        <p class="mt-3 text-gray-300">
            {{ Str::limit($laporan->isi, 100) }}
        </p>

        {{-- Gambar laporan --}}
        @if($laporan->images && $laporan->images->count() > 0)
            <div class="flex gap-2 mt-4 flex-wrap">
                @foreach($laporan->images as $img)
                    <img src="{{ asset($img->filename) }}" 
                         alt="Gambar Laporan" 
                         class="w-20 h-20 object-cover rounded border border-gray-600 shadow-md">
                @endforeach
            </div>
        @endif

        {{-- Tombol detail --}}
        <a href="{{ route('user.laporan.detail', $laporan->id) }}" 
           class="mt-4 inline-block px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded shadow transition">
            Lihat Detail
        </a>
    </div>
@empty
    <p class="text-gray-400">Belum ada laporan yang dikirim.</p>
@endforelse
@endsection
