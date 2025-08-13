@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">✏️ Edit Berita</h2>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Berita --}}
    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-4">
            <label for="judul" class="block font-medium mb-1">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" name="judul" id="judul"
                value="{{ old('judul', $berita->judul) }}"
                class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        {{-- Isi --}}
        <div class="mb-4">
            <label for="isi" class="block font-medium mb-1">Isi Berita <span class="text-red-500">*</span></label>
            <textarea name="isi" id="isi" rows="6"
                class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300"
                required>{{ old('isi', $berita->isi) }}</textarea>
        </div>

        {{-- Sumber --}}
        <div class="mb-4">
            <label for="sumber" class="block font-medium mb-1">Sumber Berita</label>
            <input type="text" name="sumber" id="sumber"
                value="{{ old('sumber', $berita->sumber) }}"
                class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300">
        </div>

        {{-- Gambar Lama --}}
        @if ($berita->gambar)
            <div class="mb-4">
                <label class="block font-medium mb-1">Gambar Saat Ini</label>
                <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar Berita"
                    class="h-48 rounded shadow border">
            </div>
        @endif

        {{-- Upload Gambar Baru --}}
        <div class="mb-4">
            <label for="gambar" class="block font-medium mb-1">Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" id="gambar"
                class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300"
                accept="image/*">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-between">
            <a href="{{ route('admin.upload-berita') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                ← Kembali
            </a>

            <button type="submit"
                class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
