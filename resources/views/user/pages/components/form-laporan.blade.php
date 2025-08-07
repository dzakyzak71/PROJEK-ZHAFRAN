@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Kirim Laporan ke Admin</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($admins->count() === 1)
            <input type="hidden" name="admin_id" value="{{ $admins->first()->id }}">
            <p>Mengirim ke: <strong>{{ $admins->first()->name }}</strong></p>
        @else
            <div class="form-group mb-3">
                <label for="admin_id">Pilih Admin</label>
                <select name="admin_id" class="form-control" required>
                    <option value="">-- Pilih Admin --</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="form-group mb-3">
            <label>Judul Laporan</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" rows="5" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Upload Gambar (boleh lebih dari 1)</label>
            <input type="file" name="gambar[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
