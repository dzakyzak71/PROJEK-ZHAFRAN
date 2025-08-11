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
        <nav class="bg-gray-900 shadow-md p-4 flex justify-between items-center">
            <div class="text-xl font-semibold text-white">
                Dashboard
            </div>
            <div class="flex items-center gap-6">
                <span class="text-gray-300 font-medium">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold transition duration-200"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </nav>



    <!-- Sidebar + Content -->
  <div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-200 min-h-screen shadow-lg">
        <div class="p-4 text-lg font-bold border-b border-gray-700">
            📌 Menu
        </div>
        <ul class="p-4 space-y-2">

            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9.75l9-6 9 6M4.5 10.5v9h15v-9" />
                    </svg>
                    Dashboard
                </a>
            </li>

            @role('superadmin')
            <li>
                <a href="{{ route('superadmin.laporan') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H8m8 0H8m8 0H8m8 0H8" />
                    </svg>
                    Laporan User
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.buat-admin') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.879 6.196a9 9 0 01-13.758 11.608z" />
                    </svg>
                    Buat Akun Admin
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.buat-user') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a7 7 0 00-14 0v2h5" />
                    </svg>
                    Buat Akun User
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.cek-bug') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.414 1.414M7.757 7.757l8.486 8.486M5.636 18.364l8.486-8.486" />
                    </svg>
                    Cek Bug
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.upload-berita') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 8v-1a2 2 0 012-2h12a2 2 0 012 2v1" />
                    </svg>
                    Upload Berita
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.tracking') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a4 4 0 00-4-4H5m14 4v-2a4 4 0 00-4-4h-1M12 12v-2m0 0L9 9m3 3l3-3" />
                    </svg>
                    Tracking IP Hacker
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.laporan-user') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-800 text-red-400 font-semibold">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M3 14h18M4 18h16" />
                    </svg>
                    Lihat Laporan User
                </a>
            </li>
            @endrole

            @role('admin')
            <li>
                <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    Lihat Laporan
                </a>
            </li>
            @endrole
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-gray-100">
        @yield('content')
    </main>
</div>



</body>
</html>
