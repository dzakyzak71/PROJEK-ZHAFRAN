@extends('layouts.superadmin')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Upload Berita</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Berita --}}
    <form action="{{ route('superadmin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="judul" class="block font-medium">Judul Berita</label>
            <input type="text" name="judul" id="judul" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="isi" class="block font-medium">Isi Berita</label>
            <textarea name="isi" id="isi" rows="6" class="w-full border p-2 rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block font-medium">Upload Gambar</label>
            <input type="file" name="gambar" id="gambar" class="w-full border p-2 rounded" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="sumber" class="block font-medium">Sumber Berita</label>
            <input type="text" name="sumber" id="sumber" class="w-full border p-2 rounded" required>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                Simpan Berita
            </button>
        </div>
    </form>

    {{-- Tabel Berita --}}
    <h3 class="text-xl font-semibold mt-10 mb-4">Daftar Berita</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4 border">#</th>
                    <th class="py-2 px-4 border">Judul</th>
                    <th class="py-2 px-4 border">Sumber</th>
                    <th class="py-2 px-4 border">Gambar</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beritas as $index => $item)
                    <tr>
                        <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border">{{ $item->judul }}</td>
                        <td class="py-2 px-4 border">{{ $item->sumber }}</td>
                        <td class="py-2 px-4 border">
                            @if($item->gambar)
                                <img src="{{ asset('storage/berita/' . $item->gambar) }}" alt="Gambar" class="h-16 rounded">
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-2 px-4 border">
                            <div class="flex gap-2">
                                <a href="{{ route('superadmin.berita.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('superadmin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
