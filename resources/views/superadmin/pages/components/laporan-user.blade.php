@extends('layouts.superadmin')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white shadow-lg rounded-xl p-4">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">📄 Daftar Laporan User</h2>
        
        <table class="w-full text-sm text-gray-700 border">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Nama User</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Isi Laporan</th>
                    <th class="px-3 py-2">Waktu Kirim</th>
                    <th class="px-3 py-2">Gambar</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $laporan)
                <tr class="border-b">
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $laporan->user->name }}</td>
                    <td class="px-3 py-2">{{ $laporan->user->email }}</td>
                    <td class="px-3 py-2">{{ Str::limit($laporan->isi, 80) }}</td>
                    <td class="px-3 py-2">{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-3 py-2">
                        @if($laporan->images->count())
                            <div class="flex flex-wrap gap-2">
                                @foreach($laporan->images as $img)
                                    <img src="{{ asset($img->filename) }}"
                                         class="w-16 h-16 object-cover rounded shadow">
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">
                        <a href="{{ route('superadmin.laporan.show', $laporan->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">👁️ Lihat</a>
                        <a href="{{ route('superadmin.laporan.pdf', $laporan->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">⬇️ PDF</a>
                        <a href="{{ route('superadmin.laporan.print', $laporan->id) }}" class="bg-gray-700 hover:bg-gray-800 text-white px-2 py-1 rounded">🖨️ Cetak</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
