@extends('layouts.superadmin')

@section('title', 'Laporan User')

@section('content')
<h2 class="text-2xl font-semibold mb-4">📋 Tampilan Laporan User</h2>

<div class="bg-gray-100 p-4 rounded-lg shadow-md max-h-[70vh] overflow-y-auto space-y-4">
    @forelse ($laporans as $laporan)
        @php
            $isSender = true; // bisa ditandai user yang mengirim
        @endphp

        <div class="flex {{ $isSender ? 'justify-start' : 'justify-end' }}">
            <div class="max-w-[70%] bg-white p-3 rounded-lg shadow-md border border-gray-200">
                <div class="text-sm text-gray-600 font-semibold mb-1">
                    {{ $laporan->user->name }}
                    <span class="text-xs text-gray-400 ml-2">{{ $laporan->created_at->format('d M Y H:i') }}</span>
                </div>

                @if ($laporan->text)
                    <p class="text-gray-800">{{ $laporan->text }}</p>
                @endif

                @if ($laporan->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/laporan_images/' . $laporan->image) }}" alt="Gambar Laporan" class="rounded-md w-60 border">
                    </div>
                @endif

                @if ($laporan->file)
                    <div class="mt-2">
                        <a href="{{ asset('storage/laporan_files/' . $laporan->file) }}" class="text-blue-500 hover:underline text-sm">📎 Unduh File</a>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600">Belum ada laporan dari user.</p>
    @endforelse
</div>
@endsection
