<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard User')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Sidebar */
        #sidebar {
            background-color: #091733;
            border-color: #0f1a45;
            color: #a0aec0;
        }
        #sidebar a:hover { background-color: #0f1a45; color: white !important; }
        #sidebar a.active { background-color: #0f1a45; color: white !important; }

        /* Navbar */
        nav {
            background-color: #091733;
            border-color: #0f1a45;
        }
        nav button { background-color: #0f1a45; }
        nav button:hover { background-color: #091733; }

        /* Main content */
        main#mainContent { background-color: rgba(9, 23, 51, 0.7); }
    </style>
</head>
<body class="bg-gradient-to-b from-[#091733] via-[#091733] to-[#0f1a45] text-gray-300">

    <!-- Navbar -->
    <nav class="shadow-md p-4 flex justify-between items-center fixed top-0 left-0 right-0 z-50 border-b">
        <div class="text-xl font-semibold text-white">User Dashboard</div>

        <div class="flex items-center gap-4">
            <span class="text-blue-300 font-medium">{{ Auth::user()->name }}</span>
            @php
                $fotoUrl = Auth::user()->foto
                    ? asset('User/' . Auth::user()->foto)
                    : asset('images/default-profile.jpg');
            @endphp
            <a href="{{ route('user.profil') }}">
                <img src="{{ $fotoUrl }}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500 shadow-md hover:scale-105 transition-transform" />
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white px-4 py-2 rounded-md font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar + Content -->
    <div class="flex pt-16 min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="shadow-lg min-h-screen sticky top-16 border-r overflow-y-auto w-64 transition-all duration-300">
            <div id="toggleSidebarBtn" class="flex items-center justify-end p-3 cursor-pointer border-b" title="Toggle Sidebar">
                <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <ul class="p-4 space-y-2">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="flex items-center p-2 rounded-lg transition hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('user.dashboard') ? 'bg-[#0f1a45] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75l9-6 9 6M4.5 10.5v9h15v-9" />
                        </svg>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.laporan.riwayat') }}" class="flex items-center p-2 rounded-lg transition hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('user.laporan.riwayat') ? 'bg-[#0f1a45] text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0H8m8 0H8m8 0H8" />
                        </svg>
                        <span class="sidebar-text">Riwayat Laporan</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main content -->
        <main id="mainContent" class="flex-1 p-6 overflow-auto transition-all duration-300">
            @if(session('success'))
                <div class="bg-green-700 bg-opacity-70 text-green-200 p-3 mb-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const mainContent = document.getElementById('mainContent');

            toggleBtn.addEventListener('click', () => {
                if (sidebar.classList.contains('w-64')) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    toggleIcon.style.transform = 'rotate(90deg)';
                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    toggleIcon.style.transform = 'rotate(0deg)';
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                }
            });
        });
    </script>
</body>
</html>
