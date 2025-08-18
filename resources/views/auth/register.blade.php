<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar - Intelijen News</title>

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
    .register-card {
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 480px;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-primary, .btn-success {
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

<div class="register-card">
  <div class="text-center">
    <div class="logo">📝 Daftar Akun</div>
  </div>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nama Lengkap</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Gmail</label>
      <div class="input-group">
        <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>
        <button type="button" id="btnOtp" class="btn btn-success">Minta Kode</button>
      </div>
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Nomor Telepon</label>
      <input type="text" name="phone" id="phone" class="form-control" placeholder="+62xxxxxxxxxx" required>
    </div>

    <div class="mb-3">
      <label for="otp" class="form-label">Kode OTP Gmail</label>
      <input type="text" name="otp" id="otp" class="form-control" placeholder="Masukkan kode OTP" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Kata Sandi</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Konfirmasi Sandi</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Daftar</button>
    </div>

    <div class="text-center mt-3">
      <a href="{{ route('login') }}">Sudah punya akun? Login</a>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Saat klik tombol minta kode
  $("#btnOtp").on("click", function() {
    let email = $("#email").val();
    let phone = $("#phone").val();

    if (!email) {
      alert("Masukkan Gmail terlebih dahulu!");
      return;
    }
    if (!phone) {
      alert("Masukkan Nomor Telepon terlebih dahulu!");
      return;
    }

    $.ajax({
      url: "{{ route('otp.send') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        email: email,
        phone: phone
      },
      success: function(res) {
        alert(res.message);
      },
      error: function(xhr) {
        alert("Gagal mengirim OTP: " + xhr.responseJSON.message);
      }
    });
  });
</script>

</body>
</html>
