<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Pengaturan | Pity Chick</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    body { 
      font-family: 'Poppins', sans-serif; 
      transition: background-color 0.3s, color 0.3s; 
    }
    
    /* Dark Mode Styles - HANYA untuk main content */
    .dark-mode main { 
      background-color: #1f2937 !important; 
      color: #e5e7eb !important; 
    }
    .dark-mode table { 
      background-color: #1f2937; 
      color: #f3f4f6; 
    }
    .dark-mode th { 
      background-color: #374151 !important; 
    }
    .dark-mode td { 
      background-color: #1f2937 !important; 
      border-color: #4b5563 !important; 
    }
    .dark-mode tr:hover td { 
      background-color: #374151 !important; 
    }
    .dark-mode .shadow-md { 
      box-shadow: none !important; 
      border-color: #4b5563 !important; 
    }
    
    /* Sidebar TETAP SAMA di semua mode - tidak berubah */
    aside {
      background: linear-gradient(180deg, #7f1d1d 0%, #991b1b 100%) !important;
    }
    .sidebar-header {
      background: linear-gradient(180deg, #991b1b 0%, #b91c1c 100%) !important;
    }

    /* Header dark mode */
    .dark-mode header {
      background-color: #1f2937 !important;
      border-color: #374151 !important;
    }
    .dark-mode header h1 {
      color: #ffffff !important;
    }
    .dark-mode header p {
      color: #d1d5db !important;
    }
    .dark-mode header button {
      color: #ef4444 !important;
    }
    .dark-mode header .material-icons {
      color: #d1d5db !important;
    }
    .dark-mode header .material-icons:hover {
      color: #ef4444 !important;
    }

    /* Notifikasi dark mode */
    .dark-mode .bg-green-100 {
      background-color: #064e3b !important;
      border-color: #047857 !important;
      color: #d1fae5 !important;
    }
    .dark-mode .bg-red-100 {
      background-color: #7f1d1d !important;
      border-color: #b91c1c !important;
      color: #fecaca !important;
    }

    /* Informasi box dark mode */
    .dark-mode .bg-blue-50 {
      background-color: #1e3a8a !important;
      border-color: #3730a3 !important;
    }
    .dark-mode .bg-yellow-50 {
      background-color: #78350f !important;
      border-color: #92400e !important;
    }
    .dark-mode .text-blue-700 {
      color: #dbeafe !important;
    }
    .dark-mode .text-yellow-700 {
      color: #fef3c7 !important;
    }
    .dark-mode .text-blue-800 {
      color: #dbeafe !important;
    }
    .dark-mode .text-yellow-800 {
      color: #fef3c7 !important;
    }
    
    /* Dark mode untuk white elements */
    .dark-mode .bg-white {
      background-color: #374151 !important;
    }
    .dark-mode .text-gray-600 {
      color: #9ca3af !important;
    }
    .dark-mode .text-gray-500 {
      color: #6b7280 !important;
    }
    .dark-mode .text-gray-800 {
      color: #f9fafb !important;
    }
    .dark-mode .border-gray-200 {
      border-color: #4b5563 !important;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
      .p-4 {
        padding: 0.75rem !important;
      }
      .p-8 {
        padding: 1rem !important;
      }
      .text-lg {
        font-size: 1rem !important;
      }
      .text-xl {
        font-size: 1.125rem !important;
      }
      .px-6 {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
      }
      .py-4 {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
      }
    }
  </style>
</head>

<body id="appBody" class="bg-gray-100 text-gray-800 transition-colors duration-500">
  <div class="flex flex-col md:flex-row h-screen">

    <!-- Sidebar - TETAP SAMA di semua mode seperti dashboard -->
    <aside id="sidebar" class="w-1/2 md:w-64 bg-red-900 text-white flex flex-col transition-transform duration-500 fixed md:relative md:translate-x-0 -translate-x-full h-full z-40 rounded-r-2xl shadow-2xl">
      <div class="p-6 text-center border-b border-red-800 bg-[url('https://www.transparenttextures.com/patterns/checkered-light-emboss.png')] sidebar-header">
        <div class="flex items-center justify-center gap-3">
          <img 
            src="{{ asset('images/pity.png') }}" 
            alt="Logo Pity Chick" 
            class="w-12 h-12 md:w-14 md:h-14 object-contain" 
          >
          <h1 class="text-xl md:text-2xl font-bold tracking-wide">Pity Chick</h1>
        </div>
      </div>
      
      <!-- User Info -->
<div class="p-4 border-b border-red-800">
  <div class="flex items-center gap-3">
    <!-- Avatar dengan inisial -->
    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-600 to-red-800 border-2 border-white flex items-center justify-center">
      <span class="text-white font-bold text-sm">
        {{ substr(auth()->user()->name, 0, 1) }}
      </span>
    </div>
    <div class="flex-1 min-w-0">
      <p class="font-medium truncate">{{ auth()->user()->name }}</p>
      <p class="text-xs text-red-200 truncate">{{ auth()->user()->email }}</p>
    </div>
  </div>
</div>

      <!-- Navigasi -->
      <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">dashboard</span> Dashboard
        </a>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">receipt</span> Pesanan
        </a>
        <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">restaurant</span> Menu
        </a>
        <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">calendar_today</span> Reservasi
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">people</span> Pelanggan
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 p-3 rounded-lg bg-red-800 hover:bg-red-700 transition">
          <span class="material-icons">settings</span> Pengaturan
        </a>
      </nav>

      <!-- Logout Section -->
      <div class="p-4 border-t border-red-800">
        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
          @csrf
          <button type="button" onclick="confirmLogout()" 
                  class="flex items-center gap-2 w-full p-3 rounded-lg hover:bg-red-700 transition text-red-100">
            <span class="material-icons">logout</span>
            <span>Keluar</span>
          </button>
        </form>
      </div>

      <div class="p-4 border-t border-red-800 text-center text-sm bg-red-900 bg-[url('https://www.transparenttextures.com/patterns/checkered-light-emboss.png')]">
        <p class="text-white">&copy; 2025 Pity Chick 🍗</p>
      </div>
    </aside>

    <!-- Overlay untuk mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-30 md:hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content - Berubah sesuai mode -->
    <main id="mainContent" class="flex-1 overflow-y-auto bg-white transition-colors duration-500">
      
      <!-- Header dengan tombol toggle sidebar mobile -->
      <header class="flex justify-between items-center px-4 md:px-6 py-4 border-b bg-white border-gray-200 transition-colors duration-500">
        <div class="flex items-center gap-3">
          <!-- Tombol toggle sidebar mobile -->
          <button id="menuButton" class="md:hidden text-red-700 transition-colors duration-500" onclick="toggleSidebar()">
            <span class="material-icons text-2xl md:text-3xl">menu</span>
          </button>
          <div>
            <h1 class="text-lg md:text-xl font-bold text-red-700 transition-colors duration-500">Kelola Pengaturan Website</h1>
            <p class="text-gray-500 text-xs md:text-sm transition-colors duration-500">Kelola semua pengaturan sistem</p>
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <div class="p-4 md:p-6">

        <!-- Notifikasi -->
        @if(session('success'))
          <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 md:mb-6 rounded transition-colors duration-500">
            <div class="flex items-center">
              <span class="material-icons text-green-500 mr-2">check_circle</span>
              {{ session('success') }}
            </div>
          </div>
        @endif
        
        @if(session('error'))
          <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 md:mb-6 rounded transition-colors duration-500">
            <div class="flex items-center">
              <span class="material-icons text-red-500 mr-2">error</span>
              {{ session('error') }}
            </div>
          </div>
        @endif

        <!-- Tabel Pengaturan -->
        <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200 transition-colors duration-500">
          <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-red-700 text-white uppercase text-xs">
              <tr>
                <th class="px-4 md:px-6 py-3 text-center">No</th>
                <th class="px-4 md:px-6 py-3">Nama Pengaturan</th>
                <th class="px-4 md:px-6 py-3">Deskripsi</th>
                <th class="px-4 md:px-6 py-3">Status</th>
                <th class="px-4 md:px-6 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <!-- Contoh data, nanti bisa di-loop dari backend -->
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">1</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-blue-600 text-sm">home</span>
                    </div>
                    <div class="font-medium">Pengaturan Beranda</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Konfigurasi tampilan halaman utama website</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Aktif
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>
              
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">2</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-purple-600 text-sm">info</span>
                    </div>
                    <div class="font-medium">Pengaturan About</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Kelola konten halaman tentang kami</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Aktif
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>
              
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">3</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-yellow-600 text-sm">star</span>
                    </div>
                    <div class="font-medium">Pengaturan Review</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Kelola testimoni dan ulasan pelanggan</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Aktif
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>
              
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">4</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-gray-600 text-sm">description</span>
                    </div>
                    <div class="font-medium">Pengaturan Footer</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Konfigurasi informasi footer website</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Aktif
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>
              
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">5</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-pink-600 text-sm">photo_library</span>
                    </div>
                    <div class="font-medium">Pengaturan Galeri</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Kelola galeri foto dan gambar website</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Perlu Update
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>

              <!-- Tambahan pengaturan lainnya -->
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                <td class="px-4 md:px-6 py-4 text-center">6</td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                      <span class="material-icons text-green-600 text-sm">email</span>
                    </div>
                    <div class="font-medium">Pengaturan Email</div>
                  </div>
                </td>
                <td class="px-4 md:px-6 py-4 text-gray-600 transition-colors duration-500">Konfigurasi sistem email dan notifikasi</td>
                <td class="px-4 md:px-6 py-4">
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Aktif
                  </span>
                </td>
                <td class="px-4 md:px-6 py-4">
                  <div class="flex gap-2 justify-center">
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">settings</span> Kelola
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 transition-colors duration-500">
            <div class="flex items-center gap-3 mb-2">
              <span class="material-icons text-blue-600">info</span>
              <h3 class="font-semibold text-blue-800 transition-colors duration-500">Informasi Sistem</h3>
            </div>
            <p class="text-sm text-blue-700 transition-colors duration-500">Semua pengaturan telah tersinkronisasi dengan database. Pastikan untuk membuat backup sebelum melakukan perubahan besar.</p>
          </div>
          
          <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 transition-colors duration-500">
            <div class="flex items-center gap-3 mb-2">
              <span class="material-icons text-yellow-600">warning</span>
              <h3 class="font-semibold text-yellow-800 transition-colors duration-500">Peringatan</h3>
            </div>
            <p class="text-sm text-yellow-700 transition-colors duration-500">Beberapa pengaturan memerlukan restart sistem untuk diterapkan. Pastikan tidak ada transaksi aktif saat melakukan perubahan.</p>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Tombol Dark Mode -->
  <button id="darkModeToggle" class="fixed bottom-6 right-6 bg-red-700 text-white p-3 rounded-full shadow-lg hover:bg-red-800 transition z-50">
    🌙
  </button>

  <!-- Logout Confirmation Modal -->
  <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl p-4 md:p-6 max-w-sm mx-4 transition-colors duration-500 shadow-2xl">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-xl flex items-center justify-center">
          <span class="material-icons text-red-600">logout</span>
        </div>
        <h3 class="text-base md:text-lg font-semibold text-gray-800 transition-colors duration-500">Konfirmasi Keluar</h3>
      </div>
      <p class="text-gray-600 mb-4 md:mb-6 transition-colors duration-500 text-sm md:text-base">Apakah Anda yakin ingin keluar dari sistem?</p>
      <div class="flex gap-2 md:gap-3 justify-end">
        <button type="button" onclick="hideLogoutModal()" 
                class="px-3 md:px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-300 font-medium text-sm md:text-base">
          Batal
        </button>
        <button type="button" onclick="performLogout()" 
                class="px-3 md:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 font-medium text-sm md:text-base">
          Ya, Keluar
        </button>
      </div>
    </div>
  </div>

  <script>
    // Sidebar Toggle Functions
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const isHidden = sidebar.classList.contains('-translate-x-full');

      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }

    let touchStartX = 0;
    let touchEndX = 0;

    const sidebar = document.getElementById('sidebar');

    sidebar.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].clientX;
    });

    sidebar.addEventListener('touchmove', (e) => {
      touchEndX = e.touches[0].clientX;
    });

    sidebar.addEventListener('touchend', () => {
      const swipeDistance = touchEndX - touchStartX;

      // Jika geser ke kanan lebih dari 50px, tutup sidebar
      if (swipeDistance > 50) {
        sidebar.classList.add('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.add('hidden');
      }
    });

    // Logout Functions
    function confirmLogout() {
      document.getElementById('logoutModal').classList.remove('hidden');
    }

    function hideLogoutModal() {
      document.getElementById('logoutModal').classList.add('hidden');
    }

    function performLogout() {
      document.getElementById('logoutForm').submit();
    }

    // Close modal when clicking outside
    document.getElementById('logoutModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideLogoutModal();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        hideLogoutModal();
      }
    });

    // Dark Mode Toggle - HANYA mempengaruhi main content
    const toggle = document.getElementById('darkModeToggle');
    const body = document.getElementById('appBody');
    const main = document.getElementById('mainContent');

    if (localStorage.theme === 'dark') enableDark();

    toggle.addEventListener('click', () => {
      body.classList.contains('dark-mode') ? disableDark() : enableDark();
    });

    function enableDark() {
      body.classList.add("dark-mode");
      body.classList.replace("bg-gray-100", "bg-gray-900");
      main.classList.replace("bg-white", "bg-gray-800");
      toggle.textContent = "☀️";
      localStorage.theme = "dark";
    }

    function disableDark() {
      body.classList.remove("dark-mode");
      body.classList.replace("bg-gray-900", "bg-gray-100");
      main.classList.replace("bg-gray-800", "bg-white");
      toggle.textContent = "🌙";
      localStorage.theme = "light";
    }
  </script>
</body>
</html>