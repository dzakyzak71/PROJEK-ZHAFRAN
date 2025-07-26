<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Intelijen News</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #2c3e50, #3498db);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 420px;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-primary {
      border-radius: 8px;
    }
    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="text-center">
    <div class="logo">🔒 Intelijen Login</div>
  </div>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
      <label for="email" class="form-label">Gmail</label>
      <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required autofocus>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Kata Sandi</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Login</button>
    </div>

    <div class="text-center mt-3">
      <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
    </div>
  </form>
</div>

</body>
</html>
