@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#0f1a45] min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-white">Data User</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
        <div class="bg-[#1a2756] shadow-lg rounded-xl p-6 flex flex-col items-center text-center hover:shadow-2xl hover:scale-105 transition duration-300">
            <!-- Foto Profil -->
            <img src="{{ $user->foto ? asset('User/' . $user->foto) : asset('images/default-profile.jpg') }}"
                 alt="{{ $user->name }}"
                 class="w-24 h-24 rounded-full object-cover border-4 border-pink-400 mb-4">

            <!-- Nama -->
            <h2 class="text-lg font-semibold text-white">{{ $user->name }}</h2>

            <!-- Gmail -->
            <p class="text-gray-300 mb-4">{{ $user->email }}</p>

            <!-- Tombol Detail Laporan -->
            <a href="{{ route('admin.detail-laporan', $user->id) }}"
               class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition duration-300">
                Detail Laporan
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
