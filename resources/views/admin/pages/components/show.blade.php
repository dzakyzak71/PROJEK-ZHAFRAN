@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-900 text-gray-200 rounded-lg shadow-lg max-w-5xl mx-auto">
    <!-- Header -->
    <h2 class="text-3xl font-bold mb-6 border-b border-gray-700 pb-3 text-center">
        Detail Laporan
    </h2>

    <!-- Info Pelapor -->
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 mb-6">
        <h3 class="text-lg font-semibold mb-3 border-b border-gray-700 pb-2">Informasi Pengirim</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <p><span class="font-semibold text-gray-400">Nama:</span> {{ $laporan->user->name }}</p>
            <p><span class="font-semibold text-gray-400">Gmail:</span> {{ $laporan->user->email }}</p>
            <p><span class="font-semibold text-gray-400">IP Address:</span> {{ $laporan->ip_address }}</p>
            <p><span class="font-semibold text-gray-400">Tanggal:</span> {{ $laporan->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <!-- Judul Laporan -->
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 mb-6">
        <h3 class="text-lg font-semibold mb-2">Judul Laporan</h3>
        <p class="text-xl font-bold text-white">{{ $laporan->judul }}</p>
    </div>

    <!-- Isi Laporan -->
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 mb-6">
        <h3 class="text-lg font-semibold mb-2">Isi Laporan</h3>
        <p class="leading-relaxed">{{ $laporan->isi }}</p>
    </div>

    <!-- Gambar -->
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 mb-6">
        <h3 class="text-lg font-semibold mb-3">Gambar Laporan</h3>
        @if($laporan->images && $laporan->images->count())
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($laporan->images as $img)
                    <img 
                        src="{{ asset($img->filename) }}" 
                        alt="Gambar laporan" 
                        class="w-48 h-48 object-cover rounded-lg shadow-md border border-gray-700 hover:scale-105 transition">
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 italic mt-2">Tidak ada gambar</p>
        @endif
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 flex justify-center space-x-4">
        <form action="{{ route('admin.components.terima', $laporan->id) }}" method="POST" onsubmit="return confirm('Terima laporan ini?')">
            @csrf
            <button type="submit" 
                class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                Terima
            </button>
        </form>
        <form action="{{ route('admin.components.tolak', $laporan->id) }}" method="POST" onsubmit="return confirm('Tolak laporan ini?')">
            @csrf
            <button type="submit" 
                class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                Tolak
            </button>
        </form>
    </div>
</div>
@endsection
