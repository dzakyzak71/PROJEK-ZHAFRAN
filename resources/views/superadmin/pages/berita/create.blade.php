@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Tambah Berita Baru</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Berita</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi Berita</label>
            <textarea name="isi" rows="5" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Berita</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
