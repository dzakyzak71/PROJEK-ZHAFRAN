<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PDF</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            margin: 30px; 
            color: #333;
            background-color: #fff;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 5px;
            color: #1a3d7c;
        }
        .section-label {
            font-weight: bold;
            color: #4a90e2;
            margin-top: 20px;
            margin-bottom: 8px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        .info p {
            margin: 4px 0;
            font-size: 14px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.5;
            background-color: #f9f9f9;
            white-space: pre-wrap; /* agar newline muncul */
            border-radius: 6px;
        }
        /* Gambar besar tunggal */
        .single-image {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        /* Container thumbnail multiple images */
        .image-thumbnails {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        /* Thumbnail gambar */
        .image-thumbnails img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            border: 1px solid #ccc;
        }
        .no-image {
            margin-top: 15px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Laporan User</h1>

    <div class="info">
        <p><span class="section-label">Nama:</span> {{ $laporan->user->name }}</p>
        <p><span class="section-label">Email:</span> {{ $laporan->user->email }}</p>
        <p><span class="section-label">Waktu:</span> {{ $laporan->created_at->format('d-m-Y H:i') }}</p>
        @if($laporan->ip_address)
        <p><span class="section-label">IP Address:</span> {{ $laporan->ip_address }}</p>
        @endif
        @if($laporan->lokasi)
        <p><span class="section-label">Lokasi:</span> {{ $laporan->lokasi }}</p>
        @endif
        
    <div>
        <div class="section-label">Judul:</div>
        <div class="box">{{ $laporan->judul }}</div>
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
                <img src="{{ public_path($img->filename) }}" 
                    style="width:150px; height:150px; object-fit:cover; border-radius:6px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
            @endforeach
        </div>
    </div>
   
    @else
    <div class="no-image">Tidak ada gambar</div>
    @endif
</body>
</html>
