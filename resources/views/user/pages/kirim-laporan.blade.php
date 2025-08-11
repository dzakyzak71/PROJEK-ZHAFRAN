@extends('layouts.user')

@section('title', 'Kirim Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Kirim Laporan ke {{ $admin->name }}</h1>

<form method="POST" action="{{ route('user.laporan.store', $admin->id) }}" 
      class="bg-white p-6 rounded shadow-md w-full max-w-xl" 
      enctype="multipart/form-data">
    @csrf

    <div class="mb-5">
        <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Laporan</label>
        <input id="judul" type="text" name="judul" 
               value="{{ old('judul') }}"
               placeholder="Masukkan judul laporan..."
               required
               class="w-full border border-gray-300 rounded px-4 py-2
                      focus:outline-none focus:ring-2 focus:ring-blue-400
                      transition duration-150 ease-in-out" />
        @error('judul') 
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <div class="mb-5">
        <label for="isi" class="block text-gray-700 font-medium mb-2">Isi Laporan</label>
        <textarea id="isi" name="isi" rows="6"
                  placeholder="Tuliskan isi laporan..."
                  required
                  class="w-full border border-gray-300 rounded px-4 py-2
                         focus:outline-none focus:ring-2 focus:ring-blue-400
                         transition duration-150 ease-in-out">{{ old('isi') }}</textarea>
        @error('isi') 
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <div class="mb-6">
        <label for="images" class="block text-gray-700 font-medium mb-2">Upload Gambar (boleh lebih dari satu)</label>
        <input id="images" type="file" name="images[]" multiple
               accept="image/*"
               class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100
                      cursor-pointer
                      focus:outline-none focus:ring-2 focus:ring-blue-400
                      transition duration-150 ease-in-out"
               onchange="previewImages(event)" />
        @error('images.*') 
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Preview Gambar -->
    <div id="image-preview" class="flex flex-wrap gap-4 mb-6"></div>

    <button type="submit"
            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow
                   hover:bg-blue-700 transition duration-150 ease-in-out">
        Kirim
    </button>
</form>

<script>
function previewImages(event) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = ''; // clear previous previews
    const files = event.target.files;
    if (files) {
        [...files].forEach(file => {
            if (!file.type.startsWith('image/')) return; // hanya image
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = "w-24 h-24 object-cover rounded shadow border";
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
