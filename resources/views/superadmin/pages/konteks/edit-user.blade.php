@extends('layouts.superadmin')

@section('title', 'Edit Akun User')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">✏️ Edit Akun User</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('superadmin.update-user', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded p-2">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('superadmin.buat-user') }}" class="text-gray-600 hover:underline">⬅️ Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
