@extends('layouts.user')

@section('title', 'Detail Laporan')

@section('content')
<h1 class="text-3xl font-semibold mb-6 text-gray-200">Detail Laporan</h1>

<div class="bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-700">
    
    {{-- Nama User --}}
    <p class="text-gray-300 mb-2">
        <span class="font-semibold text-gray-100">Nama:</span> {{ $laporan->user->name ?? 'Tidak diketahui' }}
    </p>

    {{-- Gmail User --}}
    <p class="text-gray-300 mb-4">
        <span class="font-semibold text-gray-100">Gmail:</span> {{ $laporan->user->email ?? 'Tidak diketahui' }}
    </p>

    {{-- Judul --}}
    <p class="text-gray-300 mb-2">
        <span class="font-semibold text-gray-100">Judul:</span> {{ $laporan->judul }}
    </p>

    {{-- Isi --}}
    <p class="text-gray-300 mb-4">
        <span class="font-semibold text-gray-100">Isi:</span> {{ $laporan->isi }}
    </p>

    {{-- Gambar --}}
    @if($laporan->images && $laporan->images->count() > 0)
        <div class="mt-4">
            <span class="font-semibold text-gray-100 block mb-2">Gambar:</span>
            <div class="flex gap-3 flex-wrap">
                @foreach($laporan->images as $img)
                    <img src="{{ asset($img->filename) }}" 
                        alt="Gambar Laporan" 
                        class="w-32 h-32 object-cover rounded border border-gray-600">
                @endforeach
            </div>
        </div>
    @endif

    {{-- Admin tujuan --}}
    <p class="text-gray-300 mt-6">
        <span class="font-semibold text-gray-100">Dikirim ke:</span> {{ $laporan->adminTujuan->name ?? 'Belum ditugaskan' }}
    </p>

    {{-- Tombol Kembali --}}
    <div class="mt-6">
        <a href="{{ route('user.laporan.riwayat') }}" 
           class="px-4 py-2 bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition">
            ← Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection
