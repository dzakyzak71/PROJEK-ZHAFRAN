<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Intelijen News | Welcome</title>

  <!-- Bootstrap & Chart.js -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background-color: #f7f7f7;
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
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
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

<!-- Konten -->
<div class="container py-5">


  <!-- Berita -->
  <div class="row mb-5">
    @forelse($beritas as $berita)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('storage/images/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
          <div class="card-body">
            <h5 class="card-title">{{ $berita->judul }}</h5>
            <p class="card-text">{{ Str::limit($berita->isi, 100) }}</p>
            <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-primary">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    @empty
      <p class="text-center">Belum ada berita.</p>
    @endforelse
  </div>

  <!-- Statistik Pengunjung -->
  <div class="bg-white p-4 rounded shadow-sm">
    <h4 class="mb-4">Statistik Pengunjung Mingguan</h4>
    <canvas id="visitorChart" height="100"></canvas>
  </div>
</div>

<!-- Script -->
<script>
  const ctx = document.getElementById('visitorChart').getContext('2d');
  const visitorChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($labels) !!},
      datasets: [{
        label: 'Jumlah Pengunjung',
        data: {!! json_encode($data) !!},
        borderColor: '#007bff',
        backgroundColor: 'rgba(0,123,255,0.2)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
