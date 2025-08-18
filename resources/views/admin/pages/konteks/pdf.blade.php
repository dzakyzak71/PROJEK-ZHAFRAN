<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan User - {{ $user->name }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 30px; color: #333; background-color: #fff; }
        h1 { font-size: 24px; font-weight: bold; margin-bottom: 20px; border-bottom: 2px solid #4a90e2; padding-bottom: 5px; color: #1a3d7c; text-align: center; }
        .section-label { font-weight: bold; color: #4a90e2; margin-top: 20px; margin-bottom: 8px; font-size: 16px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        .box { border: 1px solid #ccc; padding: 10px; margin-top: 5px; font-size: 14px; line-height: 1.5; background-color: #f9f9f9; white-space: pre-wrap; border-radius: 6px; }
        .image-thumbnails { margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px; }
        .image-thumbnails img { width: 150px; height: 150px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; }
        .no-image { margin-top: 10px; color: #999; font-style: italic; }
    </style>
</head>
<body>
    <h1>Laporan User - {{ $user->name }}</h1>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    @foreach($laporan as $item)
        <hr>
        <p><strong>Waktu:</strong> {{ $item->created_at->format('d-m-Y H:i') }}</p>

        <div>
            <div class="section-label">Judul:</div>
            <div class="box">{{ $item->judul }}</div>
        </div>

        <div>
            <div class="section-label">Isi Laporan:</div>
            <div class="box">{{ $item->isi }}</div>
        </div>

        <div>
            <div class="section-label">Status:</div>
            <div class="box">{{ ucfirst($item->status) }}</div>
        </div>

        <div>
            <div class="section-label">Gambar:</div>
            @if($item->images && $item->images->count() > 0)
                <div class="image-thumbnails">
                    @foreach($item->images as $img)
                        @php
                            $file = public_path($img->filename);
                            $base64 = null;
                            if(file_exists($file)) {
                                $type = pathinfo($file, PATHINFO_EXTENSION);
                                $data = file_get_contents($file);
                                $base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
                            }
                        @endphp
                        @if($base64)
                            <img src="{{ $base64 }}">
                        @else
                            <span class="no-image">File tidak ditemukan</span>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="no-image">Tidak ada gambar</div>
            @endif
        </div>
    @endforeach
</body>
</html>
