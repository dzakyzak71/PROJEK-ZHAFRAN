<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard User')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed top-0 left-0 w-full z-50">
        <!-- Logo / Title -->
        <div class="text-2xl font-bold text-blue-600 tracking-wide">
            User Panel
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-4">
            <!-- Nama User -->
            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>

            <!-- Foto Profil Bisa Klik -->
            <a href="{{ route('user.profil') }}" title="Ubah Profil">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" 
                        alt="Foto Profil" 
                        class="w-8 h-8 rounded-full object-cover border cursor-pointer hover:ring-2 hover:ring-blue-400 transition">
                @else
                    <img src="{{ asset('default-avatar.png') }}" 
                        alt="Default Avatar" 
                        class="w-8 h-8 rounded-full object-cover border cursor-pointer hover:ring-2 hover:ring-blue-400 transition">
                @endif
            </a>

            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen shadow-md">
            <div class="p-4 font-bold text-lg border-b border-gray-700">
                Menu
            </div>
            <ul class="p-4 space-y-2">
                <li>
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 transition">
                        🏠 <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.laporan.riwayat') }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 transition">
                        📋 <span>Riwayat Laporan</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 mb-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
