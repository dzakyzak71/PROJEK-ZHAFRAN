<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PDF</title>
    <style>
        body { font-family: sans-serif; }
        .judul { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .box { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="judul">Laporan User</div>

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
    <p class="label">Gambar:</p>
    <img src="{{ public_path('storage/laporan/' . $laporan->gambar) }}" width="400">
    @endif
</body>
</html>
