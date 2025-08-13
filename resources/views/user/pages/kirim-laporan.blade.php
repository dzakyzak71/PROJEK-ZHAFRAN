@extends('layouts.user')

@section('title', 'Kirim Laporan')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-900">
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg w-full max-w-2xl text-white">
        <h1 class="text-2xl font-semibold mb-6 border-b border-gray-700 pb-3">
            Kirim Laporan ke {{ $admin->name }}
        </h1>

        <form method="POST" action="{{ route('user.laporan.store', $admin->id) }}" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div class="mb-5">
                <label for="judul" class="block text-gray-300 font-medium mb-2">Judul Laporan</label>
                <input id="judul" type="text" name="judul" 
                    value="{{ old('judul') }}"
                    placeholder="Masukkan judul laporan..."
                    required
                    class="w-full border border-gray-600 rounded-lg px-4 py-2 bg-gray-900 text-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                @error('judul') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Isi -->
            <div class="mb-5">
                <label for="isi" class="block text-gray-300 font-medium mb-2">Isi Laporan</label>
                <textarea id="isi" name="isi" rows="6"
                    placeholder="Tuliskan isi laporan..."
                    required
                    class="w-full border border-gray-600 rounded-lg px-4 py-2 bg-gray-900 text-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('isi') }}</textarea>
                @error('isi') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Upload Gambar -->
            <div class="mb-6">
                <label for="images" class="block text-gray-300 font-medium mb-2">Upload Gambar (boleh lebih dari satu)</label>
                <input id="images" type="file" name="images[]" multiple
                    accept="image/*"
                    class="block w-full text-sm text-gray-400
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-600 file:text-white
                           hover:file:bg-blue-700
                           cursor-pointer
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           transition"
                    onchange="previewImages(event)" />
                @error('images.*') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Preview Gambar -->
            <div id="image-preview" class="flex flex-wrap gap-4 mb-6"></div>

            <!-- Tombol Kirim -->
            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow
                       hover:bg-blue-700 transition">
                Kirim
            </button>
        </form>
    </div>
</div>

<script>
function previewImages(event) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = ''; 
    const files = Array.from(event.target.files);

    files.forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.className = "relative w-24 h-24";

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = "w-24 h-24 object-cover rounded-lg border border-gray-600 shadow";

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.type = "button";
            removeBtn.className = "absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700";
            removeBtn.onclick = () => {
                files.splice(index, 1);
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                event.target.files = dt.files;
                wrapper.remove();
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
