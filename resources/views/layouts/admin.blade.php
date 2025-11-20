<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pity Chick Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Mobile Navbar -->
<div class="md:hidden flex items-center justify-between bg-yellow-600 text-black px-4 py-3 shadow">
    <h2 class="text-xl font-bold">Pity Chick</h2>
    <button id="mobile-menu-btn" class="text-2xl font-bold">☰</button>
</div>

<!-- ✅ BACKDROP UNTUK MOBILE -->
<div id="sidebar-backdrop" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="w-64 bg-yellow-600 text-black flex flex-col p-4 space-y-6 fixed h-full z-50 
        transform -translate-x-full md:translate-x-0 transition-transform duration-300">

        <h2 class="text-2xl font-bold">Pity Chick</h2>

        <nav class="flex flex-col space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.menus.index') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6c0-1.1-.9-2-2-2H5a2 2 0 00-2 2v13a1 1 0 001.45.89L10 18.118M12 6c0-1.1.9-2 2-2h5a2 2 0 012 2v13a1 1 0 01-1.45.89L14 18.118M12 6v12" />
                </svg>
                Menu
            </a>

            <a href="{{ route('admin.reservations.index') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Reservasi
            </a>

            <a href="{{ route('admin.tables.index') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M4 10v10m16-10v10M8 10v4m8-4v4" />
                </svg>
                Meja
            </a>

            <a href="{{ route('admin.users.index') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Pengguna
            </a>

            <a href="{{ route('admin.settings.index') }}" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0a1.724 1.724 0 002.592.93c.85-.49 1.91.37 1.41 1.23a1.724 1.724 0 00.93 2.592c.921.3.921 1.603 0 1.902a1.724 1.724 0 00-.93 2.592c.5.86-.56 1.72-1.41 1.23a1.724 1.724 0 00-2.592.93c-.3.921-1.603.921-1.902 0a1.724 1.724 0 00-2.592-.93c-.85.49-1.91-.37-1.41-1.23a1.724 1.724 0 00-.93-2.592c-.921-.3-.921-1.603 0-1.902a1.724 1.724 0 00.93-2.592c-.5-.86.56-1.72 1.41-1.23a1.724 1.724 0 002.592-.93z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />
                </svg>
                Web
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="hover:bg-yellow-700 p-2 rounded flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 md:ml-64 w-full">
        <main class="max-w-7xl mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

</div>

<!-- ✅ Mobile Sidebar Toggle Script -->
<script>
    const btn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    });

    backdrop.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    });
</script>

@stack('scripts')
</body>
</html>
