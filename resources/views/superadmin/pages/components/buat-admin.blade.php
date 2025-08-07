@extends('layouts.superadmin')

@section('title', 'Buat Akun Admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">👤 Buat Akun Admin</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('superadmin.simpan-admin') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Username</label>
            <input type="text" name="username" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            ✅ Buat Admin
        </button>
    </form>
</div>

<hr class="my-8">

<h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Daftar Akun Admin</h2>

<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
        <tr>
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Nama</th>
            <th class="px-6 py-3">Username</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        @foreach ($admins as $admin)
        <tr class="border-b">
            <td class="px-6 py-4">{{ $loop->iteration }}</td>
            <td class="px-6 py-4">{{ $admin->name }}</td>
            <td class="px-6 py-4">{{ $admin->username }}</td>
            <td class="px-6 py-4">{{ $admin->email }}</td>
            <td class="px-6 py-4 flex gap-2">
                <a href="{{ route('superadmin.edit-admin', $admin->id) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('superadmin.hapus-admin', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus admin ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
