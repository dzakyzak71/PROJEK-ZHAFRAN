@extends('layouts.user')

@section('title', 'Detail Laporan')

@section('content')
<h1 class="text-2xl font-semibold mb-4">{{ $laporan->judul }}</h1>

<div class="bg-white p-6 rounded shadow">
    <p class="text-sm text-gray-600 mb-2">Dikirim ke: <strong>{{ $laporan->adminTujuan->name }}</strong></p>
    <p class="mb-4">{{ $laporan->isi }}</p>
    <a href="{{ route('user.laporan.riwayat') }}" class="text-blue-500 hover:underline">← Kembali ke Riwayat</a>
</div>
@endsection
