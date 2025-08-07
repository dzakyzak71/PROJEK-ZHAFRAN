<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Intelijen News') }} | Beranda</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-img-top {
      height: 200px;
      object-fit: cover;
    }
    .navbar-brand {
      font-weight: bold;
      color: #2c3e50 !important;
    }
    .btn-primary {
      background-color: #2c3e50;
      border: none;
    }
    .btn-primary:hover {
      background-color: #1a242f;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">Intelijen News</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-outline-danger ms-2" type="submit">Logout</button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Konten Utama -->
<div class="container py-5">

  <!-- Judul -->
  <div class="text-center mb-5">
    <h1 class="fw-bold">Berita Terbaru</h1>
    <p class="text-muted">Informasi dari sumber terpercaya, intelijen global, dan media rahasia</p>
  </div>

  <!-- Berita -->
  <div class="row mb-5">
    @forelse($beritas as $berita)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          @if($berita->gambar)
            <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="Gambar {{ $berita->judul }}" class="card-img-top">
          @else
            <img src="https://via.placeholder.com/400x200?text=No+Image" alt="Tidak ada gambar" class="card-img-top">
          @endif
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $berita->judul }}</h5>
            <small class="text-muted d-block mb-2">
              {{ $berita->created_at->translatedFormat('d F Y') }}
              @if($berita->sumber) | {{ $berita->sumber }} @endif
            </small>
            <p class="card-text mb-4">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
            <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-primary btn-sm mt-auto">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="text-muted">Belum ada berita tersedia.</p>
      </div>
    @endforelse
  </div>

  <!-- Statistik Pengunjung -->
  <div class="bg-white p-4 rounded shadow-sm">
    <h4 class="mb-4">Statistik Pengunjung Mingguan</h4>
    <canvas id="visitorChart" height="100"></canvas>
  </div>
</div>

<!-- Footer -->
<footer class="text-center text-muted py-4 bg-light mt-5 border-top">
  <div>© {{ now()->year }} <strong>Intelijen News</strong>. All rights reserved.</div>
</footer>

<!-- Script Chart -->
<script>
  const ctx = document.getElementById('visitorChart').getContext('2d');
  const visitorChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($labels) !!},
      datasets: [{
        label: 'Jumlah Pengunjung',
        data: {!! json_encode($data) !!},
        borderColor: '#2c3e50',
        backgroundColor: 'rgba(44, 62, 80, 0.2)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 50
          }
        }
      }
    }
  });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
