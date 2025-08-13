@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-900 min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-gray-100">Data User</h1>

    @if($users->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($users as $user)
                <div
                    class="p-4 bg-gray-800 text-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center"
                >
                    {{-- Foto Profil --}}
                    <img
                        src="{{ $user->foto ? asset('User/' . $user->foto) : asset('images/default-profile.jpg') }}"
                        alt="Foto {{ $user->name }}"
                        class="w-24 h-24 rounded-full object-cover mx-auto mb-3 border-4 border-green-500 shadow-md"
                    />

                    {{-- Nama & Email --}}
                    <h2 class="text-lg font-semibold text-gray-100">{{ $user->name }}</h2>
                    <p class="text-gray-400 text-sm mb-4">{{ $user->email }}</p>

                    {{-- Tombol Kirim Laporan --}}
                    <a
                        href="{{ route('user.laporan.kirim', $user->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200"
                    >
                        Kirim Laporan
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Tidak ada user yang ditemukan.</p>
    @endif
</div>
@endsection
