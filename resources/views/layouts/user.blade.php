<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .sidebar {
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #e8f0fe;
            color: #000;
        }
        .profile-box {
            padding: 15px 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-0">
            <h4 class="text-center mt-4">User Panel</h4>
            <a href="{{ route('user.admin.list') }}" class="{{ request()->routeIs('user.admin.list') ? 'active' : '' }}">
                📦 Kirim Laporan
            </a>
            <a href="{{ route('user.laporan.index') }}" class="{{ request()->routeIs('user.laporan.index') ? 'active' : '' }}">
                🗂 Laporan Saya
            </a>
            <div class="profile-box mt-auto">
                <hr>
                <p class="mb-1"><strong>{{ Auth::user()->name }}</strong></p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm mt-2 w-100">Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
