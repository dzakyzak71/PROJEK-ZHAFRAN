@extends('layouts.superadmin')

@section('title', 'Cek Bug Sistem')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">🐞 Cek Bug Sistem</h2>

    @if(session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol scan bug --}}
    <form action="{{ route('superadmin.cek-bug.scan') }}" method="POST" class="mb-6">
        @csrf
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
            🔍 Scan Bug Sekarang
        </button>
    </form>

    {{-- Tabel hasil scan --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border text-left">Judul Bug</th>
                    <th class="px-4 py-2 border text-left">Deskripsi</th>
                    <th class="px-4 py-2 border text-left">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bugs as $bug)
                    <tr class="border-b">
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $bug->judul }}</td>
                        <td class="px-4 py-2 border">{{ $bug->deskripsi }}</td>
                        <td class="px-4 py-2 border">
                            @if($bug->status == 'Sudah Diperbaiki')
                                <span class="text-green-600 font-semibold">✔ {{ $bug->status }}</span>
                            @else
                                <span class="text-red-600 font-semibold">⛔ {{ $bug->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border text-center">
                            @if($bug->status == 'Belum Diperbaiki')
                                <form action="{{ route('superadmin.cek-bug.fix', $bug->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:underline">🔧 Perbaiki</button>
                                </form>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada bug ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
