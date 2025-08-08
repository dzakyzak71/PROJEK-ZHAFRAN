@extends('layouts.user')

@section('title', 'Kirim Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Kirim Laporan ke {{ $admin->name }}</h1>

<form method="POST" action="{{ route('user.laporan.kirim.store', $admin->id) }}" class="bg-white p-6 rounded shadow-md w-full max-w-xl">
    @csrf
    <div class="mb-4">
        <label class="block text-gray-700">Judul Laporan</label>
        <input type="text" name="judul" class="w-full mt-1 border border-gray-300 rounded px-3 py-2" required>
        @error('judul') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Isi Laporan</label>
        <textarea name="isi" rows="6" class="w-full mt-1 border border-gray-300 rounded px-3 py-2" required></textarea>
        @error('isi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kirim</button>
</form>
@endsection
