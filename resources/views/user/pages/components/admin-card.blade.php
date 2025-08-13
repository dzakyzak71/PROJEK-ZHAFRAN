@extends('layouts.admin')

@section('content')
<div class="max-w-sm mx-auto mt-10">
    <div class="p-6 bg-gray-900 rounded-lg shadow-lg text-center border border-gray-700">
        
        {{-- Foto profil --}}
        @if($admin->foto)
            <img src="{{ asset('Admin/'.$admin->foto) }}" 
                 alt="Foto Profil {{ $admin->name }}" 
                 class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-gray-600 shadow-md">
        @else
            <img src="{{ route('profil.default') }}"
                 alt="Foto Profil Default" 
                 class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-gray-600 shadow-md">
        @endif

        {{-- Nama dan Email --}}
        <h2 class="text-lg font-semibold text-gray-200">{{ $admin->name }}</h2>
        <p class="text-gray-400 text-sm">{{ $admin->email }}</p>

        {{-- Tombol kirim laporan --}}
        <a href="{{ route('user.laporan.kirim', $admin->id) }}" 
           class="mt-4 inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            Kirim Laporan
        </a>
    </div>
</div>
@endsection
