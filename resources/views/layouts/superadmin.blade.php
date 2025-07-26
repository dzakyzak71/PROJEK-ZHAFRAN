<!-- resources/views/layouts/superadmin.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Superadmin | Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Superadmin Panel</h1>
        <nav>
            <a href="{{ route('superadmin.dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
