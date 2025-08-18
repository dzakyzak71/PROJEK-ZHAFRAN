@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-900 min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-gray-100">
        Detail Laporan - {{ $user->name }}
    </h1>

    @if($laporan->count() > 0)
        <a href="{{ route('admin.laporan.detail.pdf', $user->id) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
           Cetak PDF
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Judul</th>
                        <th class="px-4 py-2 text-left">Isi Laporan</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Gambar</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $index => $item)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $item->judul }}</td>
                            <td class="px-4 py-2">{{ $item->isi }}</td>
                            <td class="px-4 py-2">
                                @if($item->status === 'diterima')
                                    <span class="bg-green-600 px-2 py-1 rounded text-sm">Diterima</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="bg-red-600 px-2 py-1 rounded text-sm">Ditolak</span>
                                @else
                                    <span class="bg-yellow-600 px-2 py-1 rounded text-sm">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($item->images && $item->images->count())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($item->images as $img)
                                            <img 
                                                src="{{ asset('Laporan_user/' . $user->folder_name . '/' . $img->filename) }}" 
                                                alt="Gambar laporan" 
                                                class="w-16 h-16 object-cover rounded shadow-sm border border-gray-600">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.laporan.show', $item->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm">
                                    Show
                                </a>
                                <form action="{{ route('admin.laporan.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-400">Belum ada laporan untuk user ini.</p>
    @endif
</div>
@endsection
