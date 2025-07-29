<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        h2 { text-align: center; }
        .label { font-weight: bold; }
        .box { border: 1px solid #ccc; padding: 10px; margin: 15px 0; }
        img { max-width: 400px; margin-top: 10px; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Pengguna</h2>

    <p><span class="label">Nama:</span> {{ $laporan->user->name }}</p>
    <p><span class="label">Email:</span> {{ $laporan->user->email }}</p>
    <p><span class="label">Waktu:</span> {{ $laporan->created_at->format('d-m-Y H:i') }}</p>
    @if($laporan->ip_address)
    <p><span class="label">IP Address:</span> {{ $laporan->ip_address }}</p>
    @endif
    @if($laporan->lokasi)
    <p><span class="label">Lokasi:</span> {{ $laporan->lokasi }}</p>
    @endif

    <div class="box">
        <p class="label">Isi Laporan:</p>
        {{ $laporan->isi }}
    </div>

    @if($laporan->gambar)
    <p class="label">Gambar Laporan:</p>
    <img src="{{ asset('storage/laporan/' . $laporan->gambar) }}">
    @endif
</body>
</html>
