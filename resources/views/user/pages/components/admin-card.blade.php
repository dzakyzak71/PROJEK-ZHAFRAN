<div class="p-4 bg-white rounded shadow text-center">
    {{-- Foto profil --}}
    @if($admin->foto)
        <img src="{{ asset('storage/'.$admin->foto) }}" 
             alt="Foto Profil {{ $admin->name }}" 
             class="w-24 h-24 rounded-full object-cover mx-auto mb-3 border-4 border-green-500 shadow-md">
    @else
        <img src="{{ route('profil.default') }}"
             alt="Foto Profil Default" 
             class="w-24 h-24 rounded-full object-cover mx-auto mb-3 border-4 border-green-500 shadow-md">
    @endif

    {{-- Nama dan Email --}}
    <h2 class="text-lg font-semibold">{{ $admin->name }}</h2>
    <p class="text-gray-600">{{ $admin->email }}</p>

    {{-- Tombol kirim laporan --}}
    <a href="{{ route('user.laporan.kirim', $admin->id) }}" 
       class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Kirim Laporan
    </a>
</div>
