<!DOCTYPE html>
<html lang="id" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Sidebar base color */
    #sidebar {
      background-color: #091733;
      border-color: #0f1a45;
      color: #a0aec0; /* text-blue-200 */
    }

    /* Custom scrollbar for sidebar */
    #sidebar::-webkit-scrollbar {
      width: 6px;
    }
    #sidebar::-webkit-scrollbar-track {
      background: transparent;
    }
    #sidebar::-webkit-scrollbar-thumb {
      background-color: #091733;
      border-radius: 3px;
    }

    /* Sidebar hover background */
    #sidebar a:hover,
    #sidebar a:focus {
      background-color: #0f1a45; /* sedikit lebih terang dari #091733 */
      color: white !important;
    }

    /* Sidebar active link */
    #sidebar a.active,
    #sidebar a.bg-blue-800 {
      background-color: #0f1a45 !important;
      color: white !important;
    }

    /* Navbar background and border */
    nav {
      background-color: #091733;
      border-color: #0f1a45;
    }

    /* Navbar logout button */
    nav button {
      background-color: #0f1a45;
      transition: background-color 0.2s;
    }
    nav button:hover {
      background-color: #091733;
    }

    /* Main content background */
    main#mainContent {
      background-color: rgba(9, 23, 51, 0.7);
    }
  </style>
</head>
<body class="bg-gradient-to-b from-[#091733] via-[#091733] to-[#0f1a45] font-inter text-gray-300">

  <!-- Navbar -->
 <nav
    class="shadow-md p-4 flex justify-between items-center fixed top-0 left-0 right-0 z-50 border-b bg-gray-900"
>
    <div class="text-xl font-semibold text-white">Admin Dashboard</div>
    <div class="flex items-center gap-6">

        {{-- Nama Admin --}}
        <span class="text-blue-300 font-medium">{{ Auth::user()->name }}</span>

        {{-- Foto Profil Admin --}}
         @php
                $fotoUrl = Auth::user()->foto
                    ? asset('Admin/' . Auth::user()->foto)
                    : asset('images/default-profile.jpg');
            @endphp
            <a href="{{ route('admin.profil') }}">
                <img src="{{ $fotoUrl }}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500 shadow-md hover:scale-105 transition-transform" />
            </a>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600 transition"
            >
                Logout
            </button>
        </form>
    </div>
</nav>


  <!-- Sidebar + Content -->
  <div class="flex pt-16 min-h-screen">

    <!-- Sidebar -->
    <aside
      id="sidebar"
      class="shadow-lg min-h-screen sticky top-16 border-r transition-all duration-300 ease-in-out overflow-y-auto w-64"
    >
      <!-- Toggle Button -->
      <div
        id="toggleSidebarBtn"
        class="flex items-center justify-end p-3 cursor-pointer border-b select-none"
        title="Toggle Sidebar"
      >
        <svg
          id="toggleIcon"
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 text-blue-400 transition-transform duration-300"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </div>

      <ul class="p-4 space-y-2">
        <li>
          <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center p-2 rounded-lg transition-colors duration-300 hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-[#0f1a45] text-white' : '' }}"
            title="Dashboard"
          >
            <svg
              class="w-5 h-5 mr-3 text-blue-400 flex-shrink-0"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 9.75l9-6 9 6M4.5 10.5v9h15v-9"
              />
            </svg>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a
            href="{{ route('admin.laporan.pending') }}"
            class="flex items-center p-2 rounded-lg transition-colors duration-300 hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('admin.laporan.pending') ? 'bg-[#0f1a45] text-white' : '' }}"
            title="Terima Laporan Pending"
          >
            <svg
              class="w-5 h-5 mr-3 text-green-400 flex-shrink-0"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0H8m8 0H8m8 0H8" />
            </svg>
            <span class="sidebar-text">Terima Laporan Pending</span>
          </a>
        </li>
        <li>
          <a
            href="{{ route('admin.upload-berita') }}"
            class="flex items-center p-2 rounded-lg transition-colors duration-300 hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('admin.berita.upload') ? 'bg-[#0f1a45] text-white' : '' }}"
            title="Upload Berita"
          >
            <svg
              class="w-5 h-5 mr-3 text-cyan-400 flex-shrink-0"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 8v-1a2 2 0 012-2h12a2 2 0 012 2v1"
              />
            </svg>
            <span class="sidebar-text">Upload Berita</span>
          </a>
        </li>
        <li>
          <a
            href="{{ route('admin.users.data') }}"
            class="flex items-center p-2 rounded-lg transition-colors duration-300 hover:bg-[#0f1a45] hover:text-white {{ request()->routeIs('admin.users.data') ? 'bg-[#0f1a45] text-white' : '' }}"
            title="Data User"
          >
            <svg
              class="w-5 h-5 mr-3 text-pink-400 flex-shrink-0"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 20h5v-2a7 7 0 00-14 0v2h5"
              />
            </svg>
            <span class="sidebar-text">Data User</span>
          </a>
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main
      class="flex-1 p-6 min-h-screen overflow-auto rounded-l-3xl shadow-inner transition-all duration-300 ease-in-out"
      id="mainContent"
      style="background-color: rgba(9, 23, 51, 0.7);"
    >
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
          // Collapse sidebar
          sidebar.classList.remove('w-64');
          sidebar.classList.add('w-20');
          toggleIcon.style.transform = 'rotate(90deg)';
          sidebarTexts.forEach(el => el.classList.add('hidden'));
          mainContent.style.marginLeft = '5rem';
        } else {
          // Expand sidebar
          sidebar.classList.remove('w-20');
          sidebar.classList.add('w-64');
          toggleIcon.style.transform = 'rotate(0deg)';
          sidebarTexts.forEach(el => el.classList.remove('hidden'));
          mainContent.style.marginLeft = '0';
        }
      });
    });
  </script>
</body>
</html>
