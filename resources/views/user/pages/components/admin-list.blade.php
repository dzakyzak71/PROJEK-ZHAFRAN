@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pilih Admin Tujuan</h2>

    <div class="row">
        @foreach($admins as $admin)
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}" class="rounded-circle mb-2" width="80" height="80" alt="Avatar">
                        <h5 class="card-title">{{ $admin->name }}</h5>
                        <a href="{{ route('user.laporan.to_admin', $admin->id) }}" class="btn btn-primary mt-2">Kirim Laporan</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
