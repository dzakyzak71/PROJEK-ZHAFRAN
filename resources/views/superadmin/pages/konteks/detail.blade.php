@extends('layouts.superadmin')

@section('title', 'Detail Laporan')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">
    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">👁️ Detail Laporan</h2>
            <span class="text-sm text-gray-300">{{ $laporan->created_at->format('d-m-Y H:i') }}</span>
        </div>

        <!-- Body -->
        <div class="p-6">
            <table class="w-full text-sm text-gray-700">
                <tbody>
                    <tr class="border-b">
                        <th class="py-2 px-3 text-left w-40 font-semibold">Nama</th>
                        <td class="py-2 px-3">{{ $laporan->user->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-3 font-semibold">Email</th>
                        <td class="py-2 px-3">{{ $laporan->user->email }}</td>
                    </tr>
                    @if($laporan->ip_address)
                    <tr class="border-b">
                        <th class="py-2 px-3 font-semibold">IP Address</th>
                        <td class="py-2 px-3">{{ $laporan->ip_address }}</td>
                    </tr>
                    @endif
                    @if($laporan->lokasi)
                    <tr class="border-b">
                        <th class="py-2 px-3 font-semibold">Lokasi</th>
                        <td class="py-2 px-3">{{ $laporan->lokasi }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Judul Laporan -->
          <div class="mt-6">
                <h5 class="font-semibold mb-2">Judul:</h5>
                <div class="bg-gray-50 p-4 rounded-lg border text-xl font-bold">{{ $laporan->judul }}</div>
            </div>


            <!-- Isi Laporan -->
            <div class="mt-6">
                <h5 class="font-semibold mb-2">Isi Laporan:</h5>
                <div class="bg-gray-50 p-4 rounded-lg border ">{{ $laporan->isi }}</div>
            </div>

            <!-- Gambar -->
                    @if($laporan->images->count() > 0)
                <div class="mt-6">
                    <h5 class="font-semibold mb-2">Gambar:</h5>
                    <div class="flex flex-wrap gap-3">
                        @foreach($laporan->images as $img)
                             <img src="{{ asset($img->filename) }}" 
                                alt="gambar"
                                class="rounded-lg border shadow-md max-w-full"
                                style="max-width: 400px;">
                        @endforeach
                    </div>
                </div>
            @else
                <span class="text-muted fst-italic">Tidak ada</span>
            @endif


            <!-- Tombol -->
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('superadmin.laporan') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                    ⬅️ Kembali
                </a>
                <a href="{{ route('superadmin.laporan.pdf', $laporan->id) }}" target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                    ⬇️ PDF
                </a>
                <a href="{{ route('superadmin.laporan.print', $laporan->id) }}" target="_blank"
                   class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg shadow">
                    🖨️ Cetak
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
