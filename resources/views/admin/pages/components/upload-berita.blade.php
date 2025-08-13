@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 bg-gray-900 rounded-lg shadow-lg text-gray-200 font-sans max-w-5xl">
    <h2 class="text-3xl font-extrabold mb-10 text-center text-white tracking-tight">Upload Berita</h2>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-700 bg-opacity-90 text-green-100 p-4 rounded-md mb-8 shadow-md transition">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="bg-red-700 bg-opacity-90 text-red-100 p-4 rounded-md mb-8 shadow-md transition">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Berita --}}
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div>
            <label for="judul" class="block mb-2 font-semibold text-gray-300">Judul Berita</label>
            <input type="text" name="judul" id="judul" class="w-full rounded-md border border-gray-700 bg-gray-800 p-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan judul berita" 
                required
            >
        </div>

        <div>
            <label for="isi" class="block mb-2 font-semibold text-gray-300">Isi Berita</label>
            <textarea name="isi" id="isi" rows="6" class="w-full rounded-md border border-gray-700 bg-gray-800 p-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Tulis isi berita di sini..." required> 
            </textarea>
        </div>

        <div>
            <label for="gambar" class="block mb-2 font-semibold text-gray-300">Upload Gambar</label>
            <label for="gambar" class="cursor-pointer inline-flex items-center justify-center w-full max-w-xs rounded-md bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 shadow-md transition font-semibold select-none" >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 12l4-4m0 0l4 4m-4-4v12" />
                </svg>
                Pilih File Gambar
            </label>
            <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*"onchange="document.getElementById('file-chosen').textContent = this.files.length > 0 ? this.files[0].name : 'Belum ada file dipilih'/>
            <p id="file-chosen" class="mt-2 text-sm text-gray-400 italic select-text">Belum ada file dipilih</p>
        </div>

        <div>
            <label for="sumber" class="block mb-2 font-semibold text-gray-300">Sumber Berita</label>
            <input type="text" name="sumber" id="sumber" class="w-full rounded-md border border-gray-700 bg-gray-800 p-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Contoh: CNN, BBC, dll" required>
        </div>

        <div class="text-center">
            <button 
                type="submit" 
                class="bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition text-white font-semibold px-10 py-3 rounded-md shadow-lg"
            >
                Simpan Berita
            </button>
        </div>
    </form>

    {{-- Tabel Daftar Berita --}}
    <h3 class="text-2xl font-semibold mt-16 mb-6 text-white border-b border-gray-700 pb-3 tracking-wide">Daftar Berita</h3>

    <div class="overflow-x-auto rounded-md shadow-lg border border-gray-700">
        <table class="min-w-full bg-gray-800 text-gray-200 table-auto">
            <thead>
                <tr class="bg-gray-700 text-left">
                    <th class="py-3 px-6 border-r border-gray-600 w-12">#</th>
                    <th class="py-3 px-6 border-r border-gray-600">Judul</th>
                    <th class="py-3 px-6 border-r border-gray-600 max-w-xs">Sumber</th>
                    <th class="py-3 px-6 border-r border-gray-600 w-28 text-center">Gambar</th>
                    <th class="py-3 px-6 border-gray-600 w-32 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beritas as $index => $item)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="py-3 px-6 border-t border-gray-700 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-6 border-t border-gray-700">{{ $item->judul }}</td>
                        <td class="py-3 px-6 border-t border-gray-700 break-words max-w-xs">{{ $item->sumber }}</td>
                        <td class="py-3 px-6 border-t border-gray-700 text-center">
                            @if($item->gambar)
                                <img src="{{ asset('storage/berita/' . $item->gambar) }}" alt="Gambar Berita" class="inline-block w-20 h-20 object-cover rounded-md shadow-md border border-gray-600" />
                            @else
                                <span class="text-gray-500 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 border-t border-gray-700">
                            <div class="flex justify-center gap-6">
                                <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-indigo-400 hover:text-indigo-600 font-semibold transition">Edit</a>

                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 italic">Belum ada berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
