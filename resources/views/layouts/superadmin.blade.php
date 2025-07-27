<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Tambahan Tailwind CSS CDN kalau belum install -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font dan Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-inter">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="text-xl font-bold text-blue-600">
            Dashboard
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-700">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Sidebar + Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-md">
            <ul class="p-4 space-y-4">
                <li><a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-blue-600">🏠 Dashboard</a></li>

                    @role('superadmin')
                    <li><a href="{{ route('superadmin.laporan') }}">📩 Laporan User</a></li>
                    <li><a href="{{ route('superadmin.buat-admin') }}">👤 Buat Akun Admin</a></li>
                    <li><a href="{{ route('superadmin.buat-user') }}">👥 Buat Akun User</a></li>
                    <li><a href="{{ route('superadmin.cek-bug') }}">🐞 Cek Bug</a></li>
                    <li><a href="{{ route('superadmin.upload-berita') }}">📰 Upload Berita</a></li>
                    <li><a href="{{ route('superadmin.tracking') }}">🛰️ Tracking IP Hacker</a></li>
                @endrole


                @role('admin')
                    <li><a href="#" class="block text-gray-700 hover:text-blue-600">📥 Lihat Laporan</a></li>
                @endrole

                @role('user')
                    <li><a href="#" class="block text-gray-700 hover:text-blue-600">✍️ Kirim Laporan</a></li>
                @endrole
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
