<form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
    @csrf
    <div class="mb-4">
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 border border-gray-300 rounded px-3 py-2">
        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Foto Profil</label>
        <input type="file" name="foto" class="mt-1">
        @if($user->foto)
            <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto Profil" class="w-24 h-24 mt-2 rounded-full object-cover">
        @endif
        @error('foto') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
</form>
