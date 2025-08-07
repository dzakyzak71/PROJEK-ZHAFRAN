@extends('layouts.user')

@section('title', 'Kirim Laporan')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-blue-600">📝 Kirim Laporan</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-lg font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul -->
        <div class="mb-6">
            <label class="block mb-2 text-lg font-semibold text-gray-700">Judul</label>
            <input type="text" name="judul" class="w-full p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('judul') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Isi Laporan -->
        <div class="mb-6">
            <label class="block mb-2 text-lg font-semibold text-gray-700">Isi Laporan</label>
            <textarea name="isi" id="isiEditor" class="w-full border border-gray-300 p-4 rounded-lg text-base" rows="10" required></textarea>
            @error('isi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        

        <!-- Gambar (boleh lebih dari satu) -->
        <div class="mb-6">
            <label class="block mb-2 text-lg font-semibold text-gray-700">Unggah Gambar (boleh lebih dari satu)</label>
            <input type="file" name="gambar[]" accept="image/*" multiple class="w-full text-base p-2">
            @error('gambar') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tombol Kirim -->
        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white text-lg px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                🚀 Kirim Laporan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#isiEditor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'alignment', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'undo', 'redo'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
