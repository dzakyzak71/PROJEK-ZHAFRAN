@extends('layouts.admin')

@section('content')
<div class="bg-gray-900 shadow-md rounded-lg p-6 min-h-screen">
    <h1 class="text-3xl font-semibold mb-6 text-gray-100">Daftar Laporan Pending</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-800 text-green-200 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">Isi</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-gray-900 divide-y divide-gray-700">
                @forelse($laporan as $index => $data)
                    <tr class="hover:bg-gray-800 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center align-middle">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center align-middle">
                            {{ $data->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center align-middle">
                            {{ $data->judul }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center align-middle">
                            {{ Str::limit($data->isi, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center align-middle">
                            @if($data->images && $data->images->count())
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach($data->images as $img)
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center align-middle">
                            {{ $data->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center align-middle" style="height: 80px;">
                            <div class="flex justify-center items-center space-x-2 h-full">
                                <a href="{{ route('admin.components.show', $data->id) }}" 
                                    class="inline-block px-3 py-1 w-20 text-center bg-blue-700 text-white text-sm rounded-md hover:bg-blue-800 transition">
                                    Lihat
                                </a>

                                <form action="{{ route('admin.components.terima', $data->id) }}" method="POST" onsubmit="return confirm('Terima laporan ini?')">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-block px-3 py-1 w-20 text-center bg-green-700 text-white text-sm rounded-md hover:bg-green-800 transition">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('admin.components.tolak', $data->id) }}" method="POST" onsubmit="return confirm('Tolak laporan ini?')">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-block px-3 py-1 w-20 text-center bg-red-700 text-white text-sm rounded-md hover:bg-red-800 transition"   >
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 italic">Tidak ada laporan pending</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
