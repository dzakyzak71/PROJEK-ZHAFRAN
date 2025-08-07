<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $berita->judul }} | Intelijen News</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f7f7f7;
      font-family: 'Segoe UI', sans-serif;
    }
    .berita-img {
      max-height: 400px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">🛰️ Intelijen News</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-outline-danger btn-sm ms-2" type="submit">Logout</button>
            </form>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Konten Detail -->
<div class="container py-5">
  <div class="bg-white p-4 rounded shadow-sm">
    <h2 class="mb-3">{{ e($berita->judul) }}</h2>
    <p class="text-muted">Dipublikasikan pada {{ $berita->created_at->translatedFormat('d F Y, H:i') }}</p>

    @if($berita->gambar)
<img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar {{ $berita->judul }}" class="card-img-top">
    @endif

    <div class="fs-5">
      {!! nl2br(e($berita->isi)) !!}
    </div>

    <div class="mt-4">
      <a href="{{ route('home') }}" class="btn btn-secondary">← Kembali ke Beranda</a>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
