<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Pesanan - Pity Chick</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

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

    /* Custom styles untuk layout yang lebih rapi */
    .card {
      transition: all 0.3s ease;
      border: 1px solid #e5e7eb;
    }
    
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .dark-mode .card {
      border-color: #4b5563 !important;
    }
    
    /* Status Badges */
    .status-badge {
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    
    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-confirmed { background-color: #d1fae5; color: #065f46; }
    .status-processed { background-color: #dbeafe; color: #1e40af; }
    .status-delivered { background-color: #e0e7ff; color: #3730a3; }
    .status-completed { background-color: #dcfce7; color: #166534; }
    .status-cancelled { background-color: #fee2e2; color: #991b1b; }
    
    .dark-mode .status-pending { background-color: #451a03; color: #fbbf24; }
    .dark-mode .status-confirmed { background-color: #022c22; color: #34d399; }
    .dark-mode .status-processed { background-color: #172554; color: #60a5fa; }
    .dark-mode .status-delivered { background-color: #1e1b4b; color: #818cf8; }
    .dark-mode .status-completed { background-color: #052e16; color: #4ade80; }
    .dark-mode .status-cancelled { background-color: #450a0a; color: #f87171; }

    /* Payment Status */
    .payment-pending { background-color: #fef3c7; color: #92400e; }
    .payment-paid { background-color: #d1fae5; color: #065f46; }
    .payment-failed { background-color: #fee2e2; color: #991b1b; }

    /* Animasi untuk loading */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-out;
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
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 p-3 rounded-lg bg-red-800 hover:bg-red-700 transition">
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
          <h1 class="text-xl font-bold text-red-700 transition-colors duration-500">Detail Pesanan</h1>
          <p class="text-gray-500 text-sm transition-colors duration-500">Informasi lengkap pesanan #{{ $order->order_id }}</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
          <span class="material-icons text-sm">arrow_back</span>
          <span>Kembali</span>
        </a>
      </div>
    </header>

    <div class="p-6 space-y-6 fade-in">
      <!-- Informasi Utama Pesanan -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Pesanan -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Card Informasi Pesanan -->
          <div class="bg-white p-6 rounded-2xl card transition-colors duration-500">
            <div class="flex justify-between items-start mb-6">
              <h2 class="text-lg font-semibold text-gray-800 transition-colors duration-500">Informasi Pesanan</h2>
              <div class="flex items-center gap-3">
                <span class="status-badge status-{{ $order->status }} capitalize">
                  {{ $order->status }}
                </span>
                <span class="text-sm text-gray-500">#{{ $order->order_id }}</span>
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div>
                  <label class="text-sm text-gray-500 font-medium">Tanggal Pesanan</label>
                  <p class="text-gray-800 font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                  <label class="text-sm text-gray-500 font-medium">Metode Pembayaran</label>
                  <p class="text-gray-800 font-semibold">{{ $order->payment_method ?? 'COD' }}</p>
                </div>
                <div>
                  <label class="text-sm text-gray-500 font-medium">Status Pembayaran</label>
                  <span class="status-badge payment-{{ $order->payment_status ?? 'pending' }} capitalize">
                    {{ $order->payment_status ?? 'pending' }}
                  </span>
                </div>
              </div>
              
              <div class="space-y-4">
                <div>
                  <label class="text-sm text-gray-500 font-medium">Total Pesanan</label>
                  <p class="text-2xl font-bold text-red-600">
                    @php
                      $grandTotal = 0;
                      if(isset($order->totals['grand_total'])) {
                          $grandTotal = $order->totals['grand_total'];
                      } else {
                          // Calculate from items if totals not available
                          if(isset($order->items) && is_array($order->items)) {
                              foreach($order->items as $item) {
                                  $grandTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                              }
                          }
                      }
                    @endphp
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                  </p>
                </div>
                <div>
                  <label class="text-sm text-gray-500 font-medium">Tipe Pesanan</label>
                  <p class="text-gray-800 font-semibold capitalize">{{ $order->order_type ?? 'Dine In' }}</p>
                </div>
                <div>
                  <label class="text-sm text-gray-500 font-medium">Catatan</label>
                  <p class="text-gray-800 font-semibold">{{ $order->notes ?? '-' }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Items Pesanan -->
          <div class="bg-white p-6 rounded-2xl card transition-colors duration-500">
            <h2 class="text-lg font-semibold text-gray-800 transition-colors duration-500 mb-6">Items Pesanan</h2>
            
            <div class="space-y-4">
              @php
                $subtotal = 0;
                $items = $order->items ?? [];
              @endphp

              @if(is_array($items) && count($items) > 0)
                @foreach($items as $item)
                  @php
                    $itemTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                    $subtotal += $itemTotal;
                  @endphp
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center gap-4">
                      <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-gray-400">restaurant</span>
                      </div>
                      <div>
                        <h3 class="font-semibold text-gray-800">{{ $item['name'] ?? 'Menu Item' }}</h3>
                        <p class="text-sm text-gray-500">
                          Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }} x {{ $item['quantity'] ?? 1 }}
                        </p>
                        @if(isset($item['notes']) && $item['notes'])
                          <p class="text-xs text-gray-400 mt-1">Catatan: {{ $item['notes'] }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="text-right">
                      <p class="font-semibold text-gray-800">Rp {{ number_format($itemTotal, 0, ',', '.') }}</p>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="text-center py-8 text-gray-500">
                  <span class="material-icons text-4xl mb-2">restaurant_menu</span>
                  <p>Tidak ada items dalam pesanan ini</p>
                </div>
              @endif
            </div>
            
            <!-- Total -->
            <div class="border-t border-gray-200 mt-6 pt-6 space-y-2">
              @php
                $tax = $order->totals['tax'] ?? 0;
                $serviceFee = $order->totals['service_fee'] ?? 0;
                $grandTotal = $subtotal + $tax + $serviceFee;
              @endphp

              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Subtotal</span>
                <span class="text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
              </div>
              @if($tax > 0)
              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Pajak</span>
                <span class="text-gray-800">Rp {{ number_format($tax, 0, ',', '.') }}</span>
              </div>
              @endif
              @if($serviceFee > 0)
              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Biaya Layanan</span>
                <span class="text-gray-800">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
              </div>
              @endif
              <div class="flex justify-between text-lg font-semibold border-t border-gray-200 pt-2">
                <span class="text-gray-800">Total</span>
                <span class="text-red-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="space-y-6">
          <!-- Card Informasi Pelanggan -->
          <div class="bg-white p-6 rounded-2xl card transition-colors duration-500">
            <h2 class="text-lg font-semibold text-gray-800 transition-colors duration-500 mb-4">Informasi Pelanggan</h2>
            
            <div class="space-y-4">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                  <span class="material-icons text-gray-400">person</span>
                </div>
                <div>
                  <h3 class="font-semibold text-gray-800">{{ $order->user->name ?? 'Guest' }}</h3>
                  <p class="text-sm text-gray-500">{{ $order->user->email ?? '-' }}</p>
                  <p class="text-sm text-gray-500">{{ $order->user->phone ?? '-' }}</p>
                </div>
              </div>
              
              <div class="space-y-2">
                <div>
                  <label class="text-sm text-gray-500 font-medium">Alamat</label>
                  <p class="text-gray-800 text-sm">{{ $order->delivery_address ?? 'Dine In' }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Timeline -->
          <div class="bg-white p-6 rounded-2xl card transition-colors duration-500">
            <h2 class="text-lg font-semibold text-gray-800 transition-colors duration-500 mb-4">Timeline Pesanan</h2>
            
            <div class="space-y-4">
              <!-- Current Status -->
              <div class="flex gap-3">
                <div class="flex flex-col items-center">
                  <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                </div>
                <div>
                  <p class="font-medium text-gray-800 capitalize">{{ $order->status }} (Saat Ini)</p>
                  <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                </div>
              </div>

              <!-- Created -->
              <div class="flex gap-3">
                <div class="flex flex-col items-center">
                  <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                  <div class="w-0.5 h-full bg-gray-200 mt-1"></div>
                </div>
                <div class="flex-1 pb-4">
                  <p class="font-medium text-gray-800">Pesanan Dibuat</p>
                  <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
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
</script>
</body>
</html>