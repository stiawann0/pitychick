<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Menu Baru | Pity Chick</title>
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

    .dark-mode header .bg-gray-100 {
        background-color: #374151 !important;
        border-color: #4b5563 !important;
    }

    .dark-mode header .text-gray-600 {
        color: #d1d5db !important;
    }

    .dark-mode header .material-icons.text-gray-600 {
        color: #9ca3af !important;
    }

    /* Sidebar TETAP SAMA di semua mode - tidak berubah */
    aside {
      background: linear-gradient(180deg, #7f1d1d 0%, #991b1b 100%) !important;
    }
    .sidebar-header {
      background: linear-gradient(180deg, #991b1b 0%, #b91c1c 100%) !important;
    }

    /* Form dark mode */
    .dark-mode .bg-white {
      background-color: #1f2937 !important;
    }
    .dark-mode .text-gray-800 {
      color: #f3f4f6 !important;
    }
    .dark-mode .text-gray-700 {
      color: #d1d5db !important;
    }
    .dark-mode .border-gray-300 {
      border-color: #4b5563 !important;
    }
    .dark-mode input, .dark-mode select, .dark-mode textarea {
      background-color: #374151 !important;
      color: #f3f4f6 !important;
      border-color: #4b5563 !important;
    }
    .dark-mode input:focus, .dark-mode select:focus, .dark-mode textarea:focus {
      border-color: #ef4444 !important;
      ring-color: #ef4444 !important;
    }
  </style>
</head>

<body id="appBody" class="bg-gray-100 text-gray-800 transition-colors duration-500">
<div class="flex flex-col md:flex-row h-screen overflow-hidden">

  <!-- Sidebar - SAMA PERSIS DENGAN DASHBOARD -->
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

  <!-- Main Content - Berubah sesuai mode -->
  <main class="flex-1 overflow-y-auto bg-white transition-colors duration-500" id="mainContent">
    <!-- Header -->
    <header class="sticky top-0 z-20 flex justify-between items-center px-6 py-4 border-b bg-white border-gray-200 transition-colors duration-500 shadow-sm">
      <div class="flex items-center gap-4">
        <button id="menuButton" class="md:hidden text-red-700 transition-colors duration-500" onclick="toggleSidebar()">
          <span class="material-icons text-3xl">menu</span>
        </button>
        <div>
          <h1 class="text-xl font-bold text-red-700 transition-colors duration-500">Tambah Menu Baru</h1>
          <p class="text-gray-500 text-sm transition-colors duration-500">Tambah menu makanan atau minuman baru</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
          <span class="material-icons text-sm">arrow_back</span>
          <span>Kembali</span>
        </a>
      </div>
    </header>

    <div class="p-6 space-y-6">
      <!-- Notifikasi sukses/error -->
      @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg transition-colors duration-500">
          <div class="flex items-center">
            <span class="material-icons text-green-500 mr-2">check_circle</span>
            {{ session('success') }}
          </div>
        </div>
      @endif

      @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg transition-colors duration-500">
          <div class="flex items-center">
            <span class="material-icons text-red-500 mr-2">error</span>
            {{ session('error') }}
          </div>
        </div>
      @endif

      <!-- Form Tambah Menu -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200 transition-colors duration-500">
        <div class="flex justify-between items-start mb-6">
          <h2 class="text-lg font-semibold text-gray-800 transition-colors duration-500">Form Tambah Menu</h2>
          <div class="flex items-center gap-2 text-red-600">
            <span class="material-icons">restaurant</span>
          </div>
        </div>
        
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-6">
              <!-- Nama Menu -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
                  Nama Menu <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors duration-500"
                    value="{{ old('name') }}" placeholder="Masukkan nama menu">
                @error('name')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                      <span class="material-icons text-sm">error</span>
                      {{ $message }}
                    </p>
                @enderror
              </div>

              <!-- Kategori -->
              <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
                  Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category" id="category" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors duration-500">
                    <option value="">Pilih Kategori</option>
                    <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
                    <option value="original" {{ old('category') == 'original' ? 'selected' : '' }}>Original</option>
                    <option value="tambahan" {{ old('category') == 'tambahan' ? 'selected' : '' }}>Tambahan</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                      <span class="material-icons text-sm">error</span>
                      {{ $message }}
                    </p>
                @enderror
              </div>

              <!-- Harga -->
              <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
                  Harga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                  <input type="number" name="price" id="price" min="0" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-12 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors duration-500"
                      value="{{ old('price') }}" placeholder="0">
                </div>
                @error('price')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                      <span class="material-icons text-sm">error</span>
                      {{ $message }}
                    </p>
                @enderror
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
              <!-- Gambar Menu -->
              <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
                  Gambar Menu
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors duration-300 hover:border-red-300">
                  <input type="file" name="image" id="image" accept="image/*" class="hidden">
                  <label for="image" class="cursor-pointer">
                    <span class="material-icons text-gray-400 text-4xl mb-2">cloud_upload</span>
                    <p class="text-sm text-gray-600 mb-2">Klik untuk upload gambar</p>
                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                  </label>
                </div>
                @error('image')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                      <span class="material-icons text-sm">error</span>
                      {{ $message }}
                    </p>
                @enderror
              </div>

              <!-- Status -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
                  Status
                </label>
                <div class="flex items-center gap-4">
                  <label class="flex items-center">
                    <input type="radio" name="is_available" value="1" checked 
                           class="text-red-600 focus:ring-red-500">
                    <span class="ml-2 text-sm text-gray-700">Tersedia</span>
                  </label>
                  <label class="flex items-center">
                    <input type="radio" name="is_available" value="0"
                           class="text-red-600 focus:ring-red-500">
                    <span class="ml-2 text-sm text-gray-700">Tidak Tersedia</span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-3 transition-colors duration-500">
              Deskripsi
            </label>
            <textarea name="description" id="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors duration-500"
                placeholder="Masukkan deskripsi menu">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                  <span class="material-icons text-sm">error</span>
                  {{ $message }}
                </p>
            @enderror
          </div>

          <!-- Tombol Aksi -->
          <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end border-t border-gray-200 pt-6">
            <a href="{{ route('admin.menus.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-300 order-2 sm:order-1">
              <span class="material-icons text-sm mr-2">close</span>
              Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors duration-300 order-1 sm:order-2">
              <span class="material-icons text-sm mr-2">save</span>
              Simpan Menu
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<!-- Tombol Dark Mode -->
<button id="darkModeToggle" class="fixed bottom-6 right-6 bg-red-700 text-white p-4 rounded-full shadow-lg hover:bg-red-800 transition-all duration-300 z-50 group">
  <span class="material-icons group-hover:scale-110 transition-transform duration-300">dark_mode</span>
</button>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-2xl p-6 max-w-sm mx-4 transition-colors duration-500 shadow-2xl">
    <div class="flex items-center gap-3 mb-4">
      <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
        <span class="material-icons text-red-600">logout</span>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 transition-colors duration-500">Konfirmasi Keluar</h3>
    </div>
    <p class="text-gray-600 mb-6 transition-colors duration-500">Apakah Anda yakin ingin keluar dari sistem?</p>
    <div class="flex gap-3 justify-end">
      <button type="button" onclick="hideLogoutModal()" 
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-300 font-medium">
        Batal
      </button>
      <button type="button" onclick="performLogout()" 
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 font-medium">
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

  // Dark Mode functions
  const body = document.getElementById("appBody");
  const main = document.getElementById("mainContent");
  const darkToggle = document.getElementById("darkModeToggle");

  if (localStorage.theme === "dark") enableDark(false);

  darkToggle.addEventListener("click", () => {
    body.classList.contains("dark-mode") ? disableDark() : enableDark();
  });

  function enableDark(update = true) {
    body.classList.add("dark-mode");
    body.classList.replace("bg-gray-100", "bg-gray-900");
    main.classList.replace("bg-white", "bg-gray-800");
    darkToggle.innerHTML = '<span class="material-icons group-hover:scale-110 transition-transform duration-300">light_mode</span>';
    localStorage.theme = "dark";
  }

  function disableDark(update = true) {
    body.classList.remove("dark-mode");
    body.classList.replace("bg-gray-900", "bg-gray-100");
    main.classList.replace("bg-gray-800", "bg-white");
    darkToggle.innerHTML = '<span class="material-icons group-hover:scale-110 transition-transform duration-300">dark_mode</span>';
    localStorage.theme = "light";
  }

  // Preview image upload
  document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const uploadArea = document.querySelector('[for="image"]');
        uploadArea.innerHTML = `
          <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg mx-auto mb-2">
          <p class="text-sm text-gray-600">Gambar terpilih</p>
          <p class="text-xs text-gray-500">Klik untuk mengganti</p>
        `;
      }
      reader.readAsDataURL(file);
    }
  });
</script>
</body>
</html>