<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard User')</title>
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
        <div class="text-2xl font-bold text-blue-600 tracking-wide">
            User Panel
        </div>

        <div class="flex items-center gap-4">
            <span class="text-gray-700 font-medium truncate max-w-[150px]">
                {{ Auth::user()->name }}
            </span>

            @php
                $fotoUrl = Auth::user()->foto
                    ? asset('User/' . Auth::user()->foto)
                    : asset('images/default-profile.jpg'); // pastikan ada default foto di public/images/
            @endphp

            <a href="{{ route('user.profil') }}" title="Ubah Profil">
                <img src="{{ $fotoUrl }}" 
                    alt="Foto Profil" 
                    class="w-10 h-10 rounded-full object-cover border-2 border-blue-500 shadow-md hover:scale-105 transition-transform" />
            </a>

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
        <aside class="w-64 bg-gray-900 text-white min-h-screen shadow-md fixed top-16 left-0">
            <div class="p-4 font-bold text-lg border-b border-gray-700">
                Menu
            </div>
            <ul class="p-4 space-y-2">
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 transition {{ request()->routeIs('user.dashboard') ? 'bg-gray-800' : '' }}">
                        🏠 <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.laporan.riwayat') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 transition {{ request()->routeIs('user.laporan.riwayat') ? 'bg-gray-800' : '' }}">
                        📋 <span>Riwayat Laporan</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6 ml-64">
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
