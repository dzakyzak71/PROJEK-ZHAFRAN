@extends('layouts.user')

@section('title', 'Riwayat Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Riwayat Laporan</h1>

@forelse ($laporans as $laporan)
    <div class="bg-white p-4 rounded shadow mb-4">
        {{-- Judul --}}
        <h2 class="text-lg font-semibold">{{ $laporan->judul }}</h2>

        {{-- Admin tujuan --}}
        <p class="text-sm text-gray-600">
            Kepada: {{ $laporan->adminTujuan->name ?? 'Belum ditugaskan' }}
        </p>

        {{-- Status laporan --}}
        <p class="mt-1">
            @if($laporan->status === 'pending')
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded">Pending</span>
            @elseif($laporan->status === 'diterima')
                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Diterima</span>
            @elseif($laporan->status === 'diproses')
                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">Diproses</span>
            @elseif($laporan->status === 'selesai')
                <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded">Selesai</span>
            @else
                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded">Tidak Diketahui</span>
            @endif
        </p>

        {{-- Isi laporan --}}
        <p class="mt-2">{{ Str::limit($laporan->isi, 100) }}</p>

        {{-- Gambar laporan --}}
        @if($laporan->images && $laporan->images->count() > 0)
        <div class="flex gap-2 mt-3 flex-wrap">
            @foreach($laporan->images as $img)
                <img src="{{ asset($img->filename) }}" 
                    alt="Gambar Laporan" 
                    class="w-20 h-20 object-cover rounded border">
            @endforeach
        </div>
    @endif


        {{-- Tombol detail --}}
        <a href="{{ route('user.laporan.detail', $laporan->id) }}" 
           class="text-blue-500 hover:underline mt-3 inline-block">
            Lihat Detail
        </a>
    </div>
@empty
    <p class="text-gray-600">Belum ada laporan yang dikirim.</p>
@endforelse
@endsection
