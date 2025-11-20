<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu | Pity Chick</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      transition: background-color 0.3s, color 0.3s;
    }

    /* Warna dark mode */
    .dark-mode {
      background-color: #111827;
      color: #e5e7eb;
    }
    .dark-mode main {
      background-color: #1f2937 !important;
    }
    
    /* Sidebar styling untuk konsistensi */
    .dark-mode aside {
      background-color: #7f1d1d !important;
    }
    .dark-mode .sidebar-header {
      background-color: #991b1b !important;
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

    /* Form dark mode */
    .dark-mode .card {
      background-color: #374151 !important;
      border-color: #4b5563 !important;
      color: #f3f4f6 !important;
    }
    .dark-mode input, 
    .dark-mode select, 
    .dark-mode textarea {
      background-color: #1f2937 !important;
      border-color: #4b5563 !important;
      color: #f3f4f6 !important;
    }
    .dark-mode input:focus, 
    .dark-mode select:focus, 
    .dark-mode textarea:focus {
      border-color: #ef4444 !important;
      box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
    }
    .dark-mode label {
      color: #d1d5db !important;
    }
    .dark-mode .text-gray-500 {
      color: #9ca3af !important;
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

    /* Custom styles untuk form */
    .card {
      transition: all 0.3s ease;
      border: 1px solid #e5e7eb;
    }
  </style>
</head>

<body id="appBody" class="bg-gray-100 text-gray-800 transition-colors duration-500">
  <div class="flex flex-col md:flex-row h-screen">

    <!-- Sidebar -->
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
        <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-2 p-3 rounded-lg bg-red-800 hover:bg-red-700 transition">
          <span class="material-icons">restaurant</span> Menu
        </a>
        <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">calendar_today</span> Reservasi
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
          <span class="material-icons">people</span> Pelanggan
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 p-3 rounded-lg hover:bg-red-700 transition">
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

    <!-- Main -->
    <main id="mainContent" class="flex-1 overflow-y-auto bg-white transition-colors duration-500">
      
      <!-- Header dengan tombol toggle sidebar mobile -->
      <header class="flex justify-between items-center px-4 md:px-8 py-4 border-b bg-white border-gray-200 transition-colors duration-500">
        <div class="flex items-center gap-3">
          <!-- Tombol toggle sidebar mobile -->
          <button id="menuButton" class="md:hidden text-red-700 transition-colors duration-500" onclick="toggleSidebar()">
            <span class="material-icons text-3xl">menu</span>
          </button>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <div>
              <h1 class="text-lg md:text-xl font-bold text-gray-800 transition-colors duration-500">Edit Menu</h1>
              <p class="text-gray-500 text-sm transition-colors duration-500">Ubah informasi menu makanan dan minuman</p>
            </div>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
            <span class="material-icons text-sm">arrow_back</span>
            <span>Kembali</span>
          </a>
        </div>
      </header>

      <!-- Content Area -->
      <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Notifikasi -->
          @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded transition-colors duration-500">
              <div class="flex items-center">
                <span class="material-icons text-red-500 mr-2">error</span>
                <div>
                  <p class="font-semibold">Terjadi kesalahan:</p>
                  <ul class="list-disc list-inside mt-1 text-sm">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          @endif

          @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded transition-colors duration-500">
              <div class="flex items-center">
                <span class="material-icons text-green-500 mr-2">check_circle</span>
                {{ session('success') }}
              </div>
            </div>
          @endif

          <!-- Form Edit Menu -->
          <div class="bg-white shadow-sm rounded-lg p-6 card transition-colors duration-500">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center transition-colors duration-500">
              Pity Chick
            </h3>
            
            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Menu -->
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700 transition-colors duration-500">
                    Nama Menu
                  </label>
                  <input type="text" 
                         name="name" 
                         id="name" 
                         value="{{ old('name', $menu->name) }}" 
                         required
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 transition-colors duration-500"
                         placeholder="Masukkan nama menu">
                </div>

                <!-- Kategori -->
                <div>
                  <label for="category" class="block text-sm font-medium text-gray-700 transition-colors duration-500">
                    Kategori
                  </label>
                  <select name="category" 
                          id="category" 
                          required
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 transition-colors duration-500">
                    @foreach(['original', 'tambahan', 'snack', 'rame-rame mania', 'minuman'] as $category)
                      <option value="{{ $category }}" 
                          {{ old('category', str_replace('-', ' ', $menu->category)) == $category ? 'selected' : '' }}>
                          {{ ucfirst($category) }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <!-- Harga -->
                <div>
                  <label for="price" class="block text-sm font-medium text-gray-700 transition-colors duration-500">
                    Harga
                  </label>
                  <input type="number" 
                         name="price" 
                         id="price" 
                         min="0" 
                         value="{{ old('price', $menu->price) }}" 
                         required
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 transition-colors duration-500"
                         placeholder="0">
                </div>

                <!-- Gambar Menu -->
                <div>
                  <label for="image" class="block text-sm font-medium text-gray-700 transition-colors duration-500">
                    Gambar Menu
                  </label>
                  <input type="file" 
                         name="image" 
                         id="image"
                         class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors duration-500">
                  
                  @if($menu->image)
                  <div class="mt-2">
                    <p class="text-sm text-gray-500 transition-colors duration-500">Gambar saat ini:</p>
                    <img src="{{ asset('storage/'.$menu->image) }}" 
                         alt="{{ $menu->name }}" 
                         class="mt-1 h-20 w-20 object-cover rounded border border-gray-200">
                  </div>
                  @endif

                  <!-- Preview Gambar Baru -->
                  <div id="imagePreview" class="mt-3 hidden">
                    <p class="text-sm text-gray-500 transition-colors duration-500">Preview Gambar Baru:</p>
                    <img id="preview" class="mt-1 h-20 w-20 object-cover rounded border border-gray-200">
                  </div>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                  <label for="description" class="block text-sm font-medium text-gray-700 transition-colors duration-500">
                    Deskripsi
                  </label>
                  <textarea name="description" 
                            id="description" 
                            rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 transition-colors duration-500"
                            placeholder="Masukkan deskripsi menu (opsional)">{{ old('description', $menu->description) }}</textarea>
                </div>
              </div>

              <!-- Tombol Aksi -->
              <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.menus.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                  Batal
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-red-600 shadow-md text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-300 flex items-center gap-2">
                  <span class="material-icons text-sm">save</span>
                  Update Menu
                </button>
              </div>
            </form>
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
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4 transition-colors duration-500">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
          <span class="material-icons text-red-600">logout</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 transition-colors duration-500">Konfirmasi Keluar</h3>
      </div>
      <p class="text-gray-600 mb-6 transition-colors duration-500">Apakah Anda yakin ingin keluar dari sistem?</p>
      <div class="flex gap-3 justify-end">
        <button type="button" onclick="hideLogoutModal()" 
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-500">
          Batal
        </button>
        <button type="button" onclick="performLogout()" 
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-500">
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

    // Image Preview
    document.getElementById('image').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const preview = document.getElementById('preview');
      const previewContainer = document.getElementById('imagePreview');

      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(file);
      } else {
        previewContainer.classList.add('hidden');
      }
    });

    // Dark Mode Toggle
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