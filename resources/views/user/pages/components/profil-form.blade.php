@extends('layouts.user')

@section('title', 'Ubah Profil')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg">
    <!-- Foto Profil -->
    <div class="relative w-32 h-32 mx-auto">
        <img id="fotoPreview"
             src="{{ $user->foto ? asset('User/' . $user->foto) : asset('images/default-profile.jpg') }}"
             alt="Foto Profil"
             class="w-32 h-32 rounded-full object-cover border border-gray-300 shadow-sm">

        <!-- Tombol Ganti Foto -->
        <label for="fotoInput"
               class="absolute bottom-1 right-1 bg-green-500 p-2 rounded-full cursor-pointer shadow hover:bg-green-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z"/>
            </svg>
        </label>
    </div>

    <!-- Form Ubah Profil -->
    <form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data" class="mt-6">
        @csrf
        <input id="fotoInput" type="file" name="foto" class="hidden" accept="image/*"
               onchange="previewImage(event)">

        <!-- Input Nama -->
        <div class="mb-4">
            <input type="text" name="name"
                   value="{{ old('name', $user->name) }}"
                   placeholder="Nama Anda"
                   class="w-full border-b border-gray-300 text-center py-2 focus:outline-none focus:border-green-500"/>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <button type="submit"
                class="w-full bg-green-500 text-white py-2 rounded-full shadow hover:bg-green-600 transition">
            Simpan Perubahan
        </button>
    </form>

    <!-- Tombol Hapus Foto -->
    @if($user->foto)
        <form action="{{ route('user.profil.hapusFoto') }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Yakin ingin menghapus foto profil?')"
                    class="w-full bg-red-500 text-white py-2 rounded-full shadow hover:bg-red-600 transition">
                Hapus Foto
            </button>
        </form>
    @endif
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('fotoPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
