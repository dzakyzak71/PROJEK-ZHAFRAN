@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#0f1a45] min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-white">
        Laporan - {{ $user->name }}
    </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-[#1a2756] rounded-lg overflow-hidden">
            <thead>
                <tr class="text-white bg-[#0f1a45]">
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">judul Laporan</th>
                    <th class="py-3 px-4">isi Laporan</th>
                    <th class="py-3 px-4">Gambar</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $laporan)
                <tr class="text-gray-200 border-b border-gray-700">
                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                     <td class="py-3 px-4">{{ $laporan->judul}}</td>
                    <td class="py-3 px-4">{{ $laporan->isi}}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-center align-middle">
                            @if($laporan->images && $laporan->images->count())
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach($laporan->images as $img)
                                        <img 
                                            src="{{ asset($img->filename) }}" 
                                            alt="Gambar laporan" 
                                            class="w-16 h-16 object-cover rounded shadow-sm border border-gray-600">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500 italic">Tidak ada</span>
                            @endif
                        </td>
                    <td class="py-3 px-4 capitalize">{{ $laporan->status }}</td>
                    <td class="py-3 px-4">{{ $laporan->created_at->format('d M Y H:i') }}</td>
                   <td class="py-3 px-4 text-center">
                    <div class="flex justify-center space-x-2">
                        <!-- Lihat -->
                        <a href="{{ route('admin.components.show', $laporan->id) }}"
                        class="px-3 py-1 bg-blue-500 rounded hover:bg-blue-600">Lihat</a>

                        <!-- Cetak -->
                        <a href="{{ route('admin.laporan.detail.pdf', $user->id) }}"
                        class="px-3 py-1 bg-green-500 rounded hover:bg-green-600">Cetak</a>

                        <!-- Hapus -->
                        <form action="{{ route('admin.laporan.hapus', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 rounded hover:bg-red-600">Hapus</button>
                        </form>
                    </div>
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-400">Tidak ada laporan diterima/ditolak.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
