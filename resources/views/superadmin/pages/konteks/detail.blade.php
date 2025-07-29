@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">👁️ Detail Laporan</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Nama</th><td>{{ $laporan->user->name }}</td></tr>
                <tr><th>Email</th><td>{{ $laporan->user->email }}</td></tr>
                <tr><th>Waktu Kirim</th><td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td></tr>
                @if($laporan->ip_address)
                <tr><th>IP Address</th><td>{{ $laporan->ip_address }}</td></tr>
                @endif
                @if($laporan->lokasi)
                <tr><th>Lokasi</th><td>{{ $laporan->lokasi }}</td></tr>
                @endif
            </table>

            <h5>Isi Laporan:</h5>
            <div class="p-3 bg-light rounded">{{ $laporan->isi }}</div>

            @if($laporan->gambar)
            <h5 class="mt-3">Gambar:</h5>
            <img src="{{ asset('storage/laporan/' . $laporan->gambar) }}" class="img-fluid rounded shadow" style="max-width: 400px;">
            @endif

            <div class="mt-4">
                <a href="{{ route('superadmin.laporan.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
                <a href="{{ route('superadmin.laporan.pdf', $laporan->id) }}" class="btn btn-success" target="_blank">⬇️ PDF</a>
                <a href="{{ route('superadmin.laporan.print', $laporan->id) }}" class="btn btn-dark" target="_blank">🖨️ Cetak</a>
            </div>
        </div>
    </div>
</div>
@endsection
