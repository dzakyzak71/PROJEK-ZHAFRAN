@extends('layouts.superadmin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold">📄 Daftar Laporan dari User</h2>

    <div class="table-responsive shadow-sm border rounded p-3 bg-white">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th style="min-width: 50px;">No</th>
                    <th style="min-width: 150px;">Nama User</th>
                    <th style="min-width: 200px;">Email</th>
                    <th style="min-width: 250px;">Isi Laporan</th>
                    <th style="min-width: 150px;">Waktu Kirim</th>
                    <th style="min-width: 120px;">Gambar</th>
                    <th style="min-width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                <tr>
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $laporan->user->name }}</td>
                    <td class="px-3 py-2">{{ $laporan->user->email }}</td>
                    <td class="px-3 py-2 text-start">{{ \Illuminate\Support\Str::limit($laporan->isi, 100) }}</td>
                    <td class="px-3 py-2">{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-3 py-2">
                        @if($laporan->gambar)
                            <img src="{{ asset('storage/laporan/' . $laporan->gambar) }}" alt="gambar" class="img-thumbnail" style="max-width: 100px;">
                        @else
                            <span class=" text-muted fst-italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">
                        <a href="{{ route('superadmin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary mb-1">👁️ Lihat</a>
                        <a href="{{ route('superadmin.laporan.pdf', $laporan->id) }}" class="btn btn-sm btn-success mb-1" target="_blank">⬇️ PDF</a>
                        <a href="{{ route('superadmin.laporan.print', $laporan->id) }}" class="btn btn-sm btn-secondary mb-1" target="_blank">🖨️ Cetak</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="mt-3 text-center text-muted"> 
                        <div style="margin-top: 20px;">
                            Belum ada laporan.
                            </div>
                        </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
