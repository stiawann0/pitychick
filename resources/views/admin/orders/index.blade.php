<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pesanan | Pity Chick</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      transition: background-color 0.3s, color 0.3s;
    }

    /* Warna dark mode - SAMA DENGAN DASHBOARD */
    .dark-mode main { 
      background-color: #1f2937 !important; 
      color: #e5e7eb !important; 
    }
    
    /* Card colors tetap sama di semua mode */
    .card-red { 
      background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important; 
      color: white !important; 
    }
    
    /* Header dark mode - SAMA DENGAN DASHBOARD */
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

    /* Sidebar TETAP SAMA di semua mode - tidak berubah */
    aside {
      background: linear-gradient(180deg, #7f1d1d 0%, #991b1b 100%) !important;
    }
    .sidebar-header {
      background: linear-gradient(180deg, #991b1b 0%, #b91c1c 100%) !important;
    }

    /* Dark mode untuk table - SESUAIKAN DENGAN DASHBOARD */
    .dark-mode table {
      background-color: #374151 !important;
      color: #f3f4f6 !important;
    }
    .dark-mode th {
      background-color: #1f2937 !important;
    }
    .dark-mode td {
      background-color: #374151 !important;
      border-color: #4b5563 !important;
    }
    .dark-mode tr:hover td {
      background-color: #4b5563 !important;
    }
    .dark-mode .shadow-md {
      box-shadow: none !important;
      border-color: #4b5563 !important;
    }
    
    /* Notifikasi dark mode - SESUAIKAN */
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

    /* Filter dark mode - SESUAIKAN */
    .dark-mode .bg-gray-200 {
      background-color: #374151 !important;
      color: #d1d5db !important;
    }
    .dark-mode .bg-gray-200:hover {
      background-color: #4b5563 !important;
    }
    .dark-mode .bg-gray-800 {
      background-color: #1f2937 !important;
      color: #ffffff !important;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
      .p-4 {
        padding: 1rem !important;
      }
      .p-8 {
        padding: 1.5rem !important;
      }
      .text-lg {
        font-size: 1rem !important;
      }
      .text-xl {
        font-size: 1.125rem !important;
      }
    }

    @media (max-width: 640px) {
      .p-4 {
        padding: 0.75rem !important;
      }
      .p-8 {
        padding: 1rem !important;
      }
      .gap-2 {
        gap: 0.5rem !important;
      }
    }
  </style>
</head>

<body id="appBody" class="bg-gray-100 text-gray-800 transition-colors duration-500">
  <div class="flex flex-col md:flex-row h-screen">

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

    <!-- Main - SAMA DENGAN DASHBOARD STYLING -->
    <main id="mainContent" class="flex-1 overflow-y-auto bg-white transition-colors duration-500">
      
      <!-- Header dengan tombol toggle sidebar mobile - KALENDER DIHILANGKAN -->
      <header class="sticky top-0 z-20 flex justify-between items-center px-4 md:px-6 py-4 border-b bg-white border-gray-200 transition-colors duration-500 shadow-sm">
        <div class="flex items-center gap-3 md:gap-4">
          <!-- Tombol toggle sidebar mobile -->
          <button id="menuButton" class="md:hidden text-red-700 transition-colors duration-500" onclick="toggleSidebar()">
            <span class="material-icons text-2xl md:text-3xl">menu</span>
          </button>
          <div>
            <h1 class="text-lg md:text-xl font-bold text-red-700 transition-colors duration-500">
              Manajemen Pesanan @if($status) - <span class="capitalize">{{ $status }}</span> @endif
            </h1>
            <p class="text-gray-500 text-xs md:text-sm transition-colors duration-500">Kelola semua pesanan pelanggan</p>
          </div>
        </div>
        <!-- KALENDER DIHAPUS DARI SINI -->
      </header>

      <!-- Content Area -->
      <div class="p-4 md:p-6">

        <!-- Filter Status -->
        <div class="flex gap-2 mb-6 flex-wrap">
          <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-500 {{ !$status ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Semua</a>
          @foreach(['pending', 'confirmed', 'processed', 'delivered', 'completed', 'cancelled'] as $filter)
            <a href="{{ route('admin.orders.index', ['status' => $filter]) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-500 {{ $status === $filter ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
              {{ ucfirst($filter) }}
            </a>
          @endforeach
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
          <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded transition-colors duration-500">
            <div class="flex items-center">
              <span class="material-icons text-green-500 mr-2">check_circle</span>
              {{ session('success') }}
            </div>
          </div>
        @endif
        @if(session('error'))
          <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded transition-colors duration-500">
            <div class="flex items-center">
              <span class="material-icons text-red-500 mr-2">error</span>
              {{ session('error') }}
            </div>
          </div>
        @endif

        <!-- Tabel Pesanan -->
        <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200 transition-colors duration-500">
          <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-red-700 text-white uppercase text-xs text-center">
              <tr>
                <th class="px-6 py-3">ID Pesanan</th>
                <th class="px-6 py-3">Customer</th>
                <th class="px-6 py-3">Metode</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-500">
                  <td class="px-6 py-4 font-mono">{{ $order->order_id }}<br><span class="text-xs text-gray-500 transition-colors duration-500">{{ $order->created_at->format('d/m/Y H:i') }}</span></td>
                  <td class="px-6 py-4">
                    {{ $order->customer['name'] ?? 'N/A' }}<br>
                    <span class="text-gray-500 text-sm transition-colors duration-500">{{ $order->customer['phone'] ?? '' }}</span>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                      {{ $order->payment_method === 'COD' ? 'bg-purple-100 text-purple-800' : '' }}
                      {{ $order->payment_method === 'Transfer' ? 'bg-blue-100 text-blue-800' : '' }}
                      {{ $order->payment_method === 'QRIS' ? 'bg-green-100 text-green-800' : '' }}">
                      {{ $order->payment_method }}
                    </span>
                    <div class="text-xs text-gray-500 mt-1 transition-colors duration-500">{{ $order->payment_status === 'paid' ? 'Lunas' : 'Pending' }}</div>
                  </td>
                  <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->totals['grand_total'] ?? 0, 0, ',', '.') }}</td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                      {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                      {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                      {{ $order->status === 'processed' ? 'bg-purple-100 text-purple-800' : '' }}
                      {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                      {{ $order->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                      {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                      {{ ucfirst($order->status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 flex gap-2 flex-wrap">
                    <a href="{{ route('admin.orders.show', $order) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                      <span class="material-icons text-sm">visibility</span> Detail
                    </a>
                    @if($order->status === 'pending')
                      <button onclick="updateOrderStatus('{{ $order->id }}','confirm')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                        <span class="material-icons text-sm">check_circle</span> Konfirmasi
                      </button>
                    @endif
                    @if($order->status === 'confirmed')
                      <button onclick="updateOrderStatus('{{ $order->id }}','process')" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                        <span class="material-icons text-sm">restaurant</span> Proses
                      </button>
                    @endif
                    @if($order->status === 'processed')
                      <button onclick="updateOrderStatus('{{ $order->id }}','deliver')" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                        <span class="material-icons text-sm">local_shipping</span> Kirim
                      </button>
                    @endif
                    @if($order->status === 'delivered')
                      <button onclick="updateOrderStatus('{{ $order->id }}','complete')" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-lg text-sm transition-colors flex items-center gap-1">
                        <span class="material-icons text-sm">done_all</span> Selesai
                      </button>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-6 py-8 text-center text-gray-500 transition-colors duration-500">
                    <div class="flex flex-col items-center justify-center">
                      <span class="material-icons text-4xl text-gray-400 mb-2">receipt</span>
                      <p class="text-lg">Belum ada pesanan</p>
                      <p class="text-sm text-gray-400 mt-1">Pesanan akan muncul di sini ketika ada yang memesan</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $orders->links() }}
        </div>

      </div>
    </main>
  </div>

  <!-- Tombol Dark Mode - SAMA DENGAN DASHBOARD -->
  <button id="darkModeToggle" class="fixed bottom-6 right-6 bg-red-700 text-white p-3 rounded-full shadow-lg hover:bg-red-800 transition z-50">
    🌙
  </button>

  <!-- Logout Confirmation Modal - SAMA DENGAN DASHBOARD -->
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
    // Sidebar Toggle Functions - SAMA DENGAN DASHBOARD
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

    // Logout Functions - SAMA DENGAN DASHBOARD
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

    // Dark Mode Toggle - SAMA DENGAN DASHBOARD (HANYA mempengaruhi main content)
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

    function updateOrderStatus(orderId, action) {
      if(!confirm('Apakah Anda yakin ingin melakukan "'+action+'" untuk pesanan ini?')) return;
      fetch(`/admin/orders/${orderId}/${action}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        if(data.success) {
          alert('✅ ' + data.message);
          setTimeout(() => location.reload(), 1000);
        } else {
          alert('❌ ' + data.message);
        }
      })
      .catch(err => { console.error(err); alert('❌ Terjadi kesalahan'); });
    }
  </script>

</body>
</html>