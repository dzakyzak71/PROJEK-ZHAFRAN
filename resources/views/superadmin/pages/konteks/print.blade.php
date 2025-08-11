<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 25px 40px;
            color: #222;
            background-color: #fff;
        }
        h2 {
            text-align: center;
            font-weight: 700;
            font-size: 28px;
            color: #1a3d7c;
            margin-bottom: 30px;
            border-bottom: 3px solid #4a90e2;
            padding-bottom: 10px;
        }
        .label {
            font-weight: 600;
            color: #4a90e2;
        }
        .info p {
            margin: 8px 0;
            font-size: 15px;
            line-height: 1.4;
        }
        .box {
            border: 1px solid #ccc;
            padding: 18px 20px;
            margin: 20px 0;
            font-size: 15px;
            line-height: 1.6;
            background-color: #f9f9f9;
            border-radius: 8px;
            white-space: pre-wrap; /* biar enter di teks tampil */
            box-shadow: inset 0 0 5px #e0e0e0;
        }
        .section-label {
            font-weight: 700;
            color: #1a3d7c;
            font-size: 17px;
            margin-top: 30px;
            margin-bottom: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .image-thumbnails {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        .image-thumbnails img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.15);
            border: 1px solid #ccc;
            transition: transform 0.3s ease;
        }
        .image-thumbnails img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            cursor: pointer;
        }
        .no-image {
            margin-top: 20px;
            color: #777;
            font-style: italic;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Pengguna</h2>

    <div class="info">
        <p><span class="label">Nama:</span> {{ $laporan->user->name }}</p>
        <p><span class="label">Email:</span> {{ $laporan->user->email }}</p>
        <p><span class="label">Waktu:</span> {{ $laporan->created_at->format('d-m-Y H:i') }}</p>
        @if($laporan->ip_address)
            <p><span class="label">IP Address:</span> {{ $laporan->ip_address }}</p>
        @endif
        @if($laporan->lokasi)
            <p><span class="label">Lokasi:</span> {{ $laporan->lokasi }}</p>
        @endif
    </div>

    <div>
        <div class="section-label">Isi Laporan:</div>
        <div class="box">{{ $laporan->isi }}</div>
    </div>

    @if($laporan->images->count() > 0)
        <div>
            <div class="section-label">Gambar:</div>
            <div class="image-thumbnails">
                @foreach($laporan->images as $img)
                    <img src="{{ asset($img->filename) }}" alt="Gambar Laporan">
                @endforeach
            </div>
        </div>
    @else
        <div class="no-image">Tidak ada gambar</div>
    @endif
</body>
</html>
