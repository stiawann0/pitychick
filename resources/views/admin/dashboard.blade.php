<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pity Chick Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    /* Card colors tetap sama di semua mode */
    .card-red { 
      background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important; 
      color: white !important; 
    }
    .card-orange { 
      background: linear-gradient(135deg, #f97316 0%, #fb923c 100%) !important; 
      color: white !important; 
    }
    
    /* Card putih tetap putih di dark mode */
    .card-white {
      background: white !important;
      color: #1f2937 !important;
    }
    .dark-mode .card-white {
      background: white !important;
      color: #1f2937 !important;
    }
    .dark-mode .card-white .text-gray-500 {
      color: #6b7280 !important;
    }
    .dark-mode .card-white .text-gray-800 {
      color: #1f2937 !important;
    }
    .dark-mode .card-white .border-gray-400 {
      border-color: #d1d5db !important;
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

    /* Responsive improvements */
    canvas { 
      max-height: 280px !important; 
    }
    
    /* Custom styles untuk layout wireframe */
    .stat-card {
      transition: all 0.3s ease;
      min-height: 140px;
    }
    
    .stat-card:hover {
      transform: translateY(-2px);
    }
    
    .growth-card {
      transition: all 0.3s ease;
    }
    
    .growth-card:hover {
      transform: translateY(-2px);
    }
    
    .chart-container {
      min-height: 320px;
    }
    
    /* Dark mode untuk growth card - TETAP BERUBAH */
    .dark-mode .growth-card {
      background-color: #374151 !important;
      border-color: #4b5563 !important;
    }
    
    .dark-mode .growth-card .text-gray-500 {
      color: #d1d5db !important;
    }
    
    .dark-mode .growth-card .text-gray-800 {
      color: #f9fafb !important;
    }
    
    .dark-mode .growth-card .text-gray-600 {
      color: #e5e7eb !important;
    }
    
    .dark-mode .growth-card .border-gray-200 {
      border-color: #4b5563 !important;
    }

    /* Dark mode untuk form elements */
    .dark-mode select {
      background-color: #374151 !important; 
      color: #f3f4f6 !important; 
      border-color: #4b5563 !important;
    }
    .dark-mode select:focus {
      outline: none;
      border-color: #9ca3af !important;
      box-shadow: 0 0 0 2px rgba(156,163,175,0.3);
    }

    /* Dark mode untuk chart cards - TETAP BERUBAH */
    .dark-mode .bg-white:not(.card-white) {
      background-color: #374151 !important;
    }
    .dark-mode .text-gray-800:not(.card-white *) {
      color: #f9fafb !important;
    }
    .dark-mode .text-gray-600:not(.card-white *) {
      color: #d1d5db !important;
    }
    .dark-mode .text-gray-500:not(.card-white *) {
      color: #9ca3af !important;
    }
    .dark-mode .border-gray-400:not(.card-white *) {
      border-color: #4b5563 !important;
    }
    
    /* Animasi untuk loading */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-out;
    }

    /* Responsive improvements */
    @media (max-width: 1024px) {
      .grid-cols-4 {
        grid-template-columns: repeat(1, 1fr) !important;
      }
      .col-span-3 {
        grid-column: span 1 !important;
      }
      .col-span-1 {
        grid-column: span 1 !important;
      }
    }

    @media (max-width: 768px) {
      .p-6 {
        padding: 1rem !important;
      }
      .text-4xl {
        font-size: 2rem !important;
      }
      .text-3xl {
        font-size: 1.75rem !important;
      }
      .grid.grid-cols-3 {
        grid-template-columns: repeat(1, 1fr) !important;
        gap: 1rem !important;
      }
      .chart-container {
        min-height: 250px !important;
      }
    }

    @media (max-width: 640px) {
      .p-6 {
        padding: 0.75rem !important;
      }
      .text-4xl {
        font-size: 1.5rem !important;
      }
      .text-3xl {
        font-size: 1.25rem !important;
      }
      .w-12.h-12 {
        width: 2rem !important;
        height: 2rem !important;
      }
      .material-icons {
        font-size: 1rem !important;
      }
    }
  </style>
</head>

<body id="appBody" class="bg-gray-100 text-gray-800 transition-colors duration-500">
<div class="flex flex-col md:flex-row h-screen overflow-hidden">

  <!-- Sidebar - TETAP SAMA di semua mode -->
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
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 p-3 rounded-lg bg-red-800 hover:bg-red-700 transition">
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
    <header class="sticky top-0 z-20 flex justify-between items-center px-4 md:px-6 py-4 border-b bg-white border-gray-200 transition-colors duration-500 shadow-sm">
      <div class="flex items-center gap-3 md:gap-4">
        <button id="menuButton" class="md:hidden text-red-700 transition-colors duration-500" onclick="toggleSidebar()">
          <span class="material-icons text-2xl md:text-3xl">menu</span>
        </button>
        <div>
          <h1 class="text-lg md:text-xl font-bold text-red-700 transition-colors duration-500">Selamat Datang, {{ auth()->user()->name }}!</h1>
          <p class="text-gray-500 text-xs md:text-sm transition-colors duration-500">Berikut performa restoran Pity Chick hari ini</p>
        </div>
      </div>
      <div class="flex items-center gap-2 md:gap-3">
        <div class="hidden md:flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-lg">
            <span class="material-icons text-gray-600 text-sm">calendar_today</span>
            <span class="text-sm text-gray-600" id="currentDate"></span>
          </div>
      </div>
    </header>

    <div class="p-4 md:p-6 space-y-4 md:space-y-6 fade-in">
      <!-- Layout Wireframe Style: 7 cards in 2 rows + 1 vertical card -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 md:gap-6">
        
        <!-- Left Section - 7 Cards in 2 rows -->
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
          
          <!-- Row 1: 3 horizontal cards -->
          <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Pesanan Baru -->
            <div class="p-4 md:p-6 rounded-2xl stat-card card-red">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-base md:text-lg font-semibold flex items-center gap-2 mb-2">
                    <span class="material-icons text-yellow-300">local_fire_department</span> 
                    <span class="hidden sm:inline">Pesanan Baru</span>
                    <span class="sm:hidden">Pesanan</span>
                  </h2>
                  <p class="text-2xl md:text-4xl font-bold mt-2">{{ $stats['todayOrders'] }}</p>
                  <p class="text-xs md:text-sm opacity-90 mt-1">Menunggu Hari Ini</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-white text-lg md:text-xl">shopping_cart</span>
                </div>
              </div>
            </div>

            <!-- Reservasi Mendesak -->
            <div class="p-4 md:p-6 rounded-2xl stat-card card-orange">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-base md:text-lg font-semibold flex items-center gap-2 mb-2">
                    <span class="material-icons text-yellow-200">warning</span> 
                    <span class="hidden sm:inline">Reservasi</span>
                  </h2>
                  <p class="text-2xl md:text-4xl font-bold mt-2">{{ $stats['reservationStats']['pending'] }}</p>
                  <p class="text-xs md:text-sm opacity-90 mt-1">Perlu Dikonfirmasi</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-white text-lg md:text-xl">event_available</span>
                </div>
              </div>
            </div>

            <!-- Penjualan Hari Ini -->
            <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 stat-card card-white transition-colors duration-500">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-xs md:text-sm text-gray-500 font-medium">Penjualan Hari Ini</h2>
                  <p class="text-xl md:text-3xl font-bold text-red-700 mt-2 md:mt-3">Rp {{ number_format($stats['todayRevenue'],0,',','.') }}</p>
                  <div class="flex items-center gap-1 mt-1 md:mt-2">
                    @php
                      $yesterdayRevenue = $stats['yesterdayRevenue'] ?? 0;
                      $todayRevenue = $stats['todayRevenue'] ?? 0;
                      
                      if ($yesterdayRevenue > 0) {
                          $growth = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
                      } else {
                          $growth = $todayRevenue > 0 ? 100 : 0;
                      }
                    @endphp
                    
                    @if($growth > 0)
                      <span class="material-icons text-green-500 text-xs md:text-sm">trending_up</span>
                      <span class="text-xs text-green-600 font-medium">+{{ number_format($growth, 1) }}%</span>
                    @elseif($growth < 0)
                      <span class="material-icons text-red-500 text-xs md:text-sm">trending_down</span>
                      <span class="text-xs text-red-600 font-medium">{{ number_format($growth, 1) }}%</span>
                    @else
                      <span class="material-icons text-gray-500 text-xs md:text-sm">remove</span>
                      <span class="text-xs text-gray-600 font-medium">0%</span>
                    @endif
                  </div>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-green-600 text-lg md:text-xl">attach_money</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Row 2: 3 horizontal cards aligned below first three cards -->
          <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Total Pelanggan -->
            <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 stat-card card-white transition-colors duration-500">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-xs md:text-sm text-gray-500 font-medium">Total Pelanggan</h2>
                  <p class="text-xl md:text-3xl font-bold text-purple-600 mt-2 md:mt-3">{{ $stats['totalUsers'] }}</p>
                  <p class="text-xs text-gray-500 mt-1">Pelanggan Terdaftar</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-purple-600 text-lg md:text-xl">people</span>
                </div>
              </div>
            </div>

            <!-- Total Menu -->
            <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 stat-card card-white transition-colors duration-500">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-xs md:text-sm text-gray-500 font-medium">Total Menu</h2>
                  <p class="text-xl md:text-3xl font-bold text-blue-600 mt-2 md:mt-3">{{ $stats['totalMenus'] }}</p>
                  <p class="text-xs text-gray-500 mt-1">Menu Tersedia</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-blue-600 text-lg md:text-xl">restaurant</span>
                </div>
              </div>
            </div>

            <!-- Pesanan Selesai Hari Ini -->
            <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 stat-card card-white transition-colors duration-500">
              <div class="flex justify-between items-start">
                <div>
                  <h2 class="text-xs md:text-sm text-gray-500 font-medium">Pesanan Selesai</h2>
                  <p class="text-xl md:text-3xl font-bold text-indigo-600 mt-2 md:mt-3">{{ $stats['ordersCompletedToday'] }}</p>
                  <p class="text-xs text-gray-500 mt-1">Hari Ini</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                  <span class="material-icons text-indigo-600 text-lg md:text-xl">check_circle</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right Section - Tall vertical card spanning both rows -->
        <div class="lg:col-span-1">
          <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 growth-card transition-colors duration-500 h-full">
            <div class="flex items-center justify-between mb-3 md:mb-4">
              <h2 class="text-base md:text-lg font-semibold text-gray-800 transition-colors duration-500">Pertumbuhan</h2>
              <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <span class="material-icons text-green-600 text-lg md:text-xl">trending_up</span>
              </div>
            </div>
            
            <div class="space-y-3 md:space-y-4">
              <!-- Current Month -->
              <div class="flex justify-between items-center">
                <div>
                  <p class="text-xs text-gray-500 font-medium">Bulan Ini</p>
                  <p class="text-lg md:text-xl font-bold text-gray-800 transition-colors duration-500">
                    Rp {{ number_format($stats['monthlyRevenue'],0,',','.') }}
                  </p>
                </div>
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
              </div>
              
              <!-- Last Month -->
              <div class="flex justify-between items-center">
                <div>
                  <p class="text-xs text-gray-500 font-medium">Bulan Lalu</p>
                  <p class="text-base md:text-lg font-semibold text-gray-600 transition-colors duration-500">
                    @if(($stats['lastMonthRevenue'] ?? 0) > 0)
                        Rp {{ number_format($stats['lastMonthRevenue'], 0, ',', '.') }}
                    @else
                        <span class="text-gray-400">Tidak ada data</span>
                    @endif
                  </p>
                </div>
                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
              </div>
              
              <!-- Growth Indicator -->
              <div class="pt-3 md:pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 md:gap-3">
                  @php
                    $lastMonthRevenue = $stats['lastMonthRevenue'] ?? 0;
                    $currentMonthRevenue = $stats['monthlyRevenue'] ?? 0;
                    
                    if ($lastMonthRevenue > 0) {
                        $growthPercentage = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
                    } else {
                        $growthPercentage = $currentMonthRevenue > 0 ? 100 : 0;
                    }
                  @endphp
                  
                  @if($growthPercentage > 0)
                    <div class="flex items-center gap-1 md:gap-2 bg-green-50 px-2 md:px-3 py-1 md:py-2 rounded-lg">
                      <span class="material-icons text-green-600 text-xs md:text-sm">arrow_upward</span>
                      <span class="text-xs md:text-sm font-semibold text-green-600">+{{ number_format($growthPercentage, 1) }}%</span>
                    </div>
                    <span class="text-xs text-green-600 font-medium">Naik</span>
                  @elseif($growthPercentage < 0)
                    <div class="flex items-center gap-1 md:gap-2 bg-red-50 px-2 md:px-3 py-1 md:py-2 rounded-lg">
                      <span class="material-icons text-red-500 text-xs md:text-sm">arrow_downward</span>
                      <span class="text-xs md:text-sm font-semibold text-red-600">{{ number_format($growthPercentage, 1) }}%</span>
                    </div>
                    <span class="text-xs text-red-600 font-medium">Turun</span>
                  @else
                    <div class="flex items-center gap-1 md:gap-2 bg-gray-50 px-2 md:px-3 py-1 md:py-2 rounded-lg">
                      <span class="material-icons text-gray-500 text-xs md:text-sm">remove</span>
                      <span class="text-xs md:text-sm font-semibold text-gray-600">0%</span>
                    </div>
                    <span class="text-xs text-gray-500">Stabil</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Grafik Section -->
      <section class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-8">
        <!-- Grafik Pemesanan -->
        <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 card transition-colors duration-500 chart-container">
          <div class="flex justify-between items-center mb-4 md:mb-6">
            <h2 class="text-base md:text-lg font-semibold flex items-center gap-2 text-gray-800 transition-colors duration-500">
              <span class="material-icons text-red-600">bar_chart</span> 
              <span class="hidden sm:inline">Grafik Pemesanan</span>
              <span class="sm:hidden">Pemesanan</span>
            </h2>
            <select id="orderPeriodSelect" class="border border-gray-300 rounded-lg px-2 md:px-3 py-1 md:py-2 text-xs md:text-sm transition-colors duration-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
              <option value="daily">Harian</option>
              <option value="weekly">Mingguan</option>
              <option value="monthly" selected>Bulanan</option>
            </select>
          </div>
          <div class="h-48 md:h-64">
            <canvas id="orderChart"></canvas>
          </div>
        </div>

        <!-- Grafik Reservasi -->
        <div class="bg-white p-4 md:p-6 rounded-2xl border border-gray-400 card transition-colors duration-500 chart-container">
          <div class="flex justify-between items-center mb-4 md:mb-6">
            <h2 class="text-base md:text-lg font-semibold flex items-center gap-2 text-gray-800 transition-colors duration-500">
              <span class="material-icons text-orange-500">insert_chart</span> 
              <span class="hidden sm:inline">Grafik Reservasi</span>
              <span class="sm:hidden">Reservasi</span>
            </h2>
            <select id="reservationPeriodSelect" class="border border-gray-300 rounded-lg px-2 md:px-3 py-1 md:py-2 text-xs md:text-sm transition-colors duration-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
              <option value="daily">Harian</option>
              <option value="weekly">Mingguan</option>
              <option value="monthly" selected>Bulanan</option>
            </select>
          </div>
          <div class="h-48 md:h-64">
            <canvas id="reservationChart"></canvas>
          </div>
        </div>
      </section>
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
  // Set current date
  document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });

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

  let orderChart, reservationChart;

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

  // Chart functions
  async function fetchChartData(type, period = 'monthly') {
    try {
      const baseUrl = type === 'order' 
        ? "{{ route('admin.dashboard.ordersChart') }}"
        : "{{ route('admin.dashboard.reservationsChart') }}";
      
      const url = `${baseUrl}?period=${period}`;
      console.log(`🔄 Fetching ${type} chart with period: ${period}`);
      
      const response = await fetch(url);
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      
      const data = await response.json();
      console.log(`✅ ${type} chart data received:`, data);
      return data;
      
    } catch (error) {
      console.error(`❌ Error fetching ${type} chart:`, error);
      
      // Fallback dummy data
      const fallbackData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        data: type === 'order' ? [12, 19, 3, 5, 2, 3] : [5, 8, 12, 7, 9, 11]
      };
      
      console.log(`📊 Using fallback data for ${type} chart`);
      return fallbackData;
    }
  }

  function renderOrderChart(data) {
    const ctx = document.getElementById('orderChart');
    
    if (orderChart) {
      orderChart.destroy();
    }

    orderChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.labels || [],
        datasets: [{ 
          label: 'Pemesanan',
          data: data.data || [],
          borderColor: '#b91c1c',
          backgroundColor: 'rgba(185,28,28,0.1)',
          tension: 0.4,
          fill: true,
          pointBackgroundColor: '#b91c1c',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 4,
          borderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { 
            ticks: { color: '#374151' }, 
            grid: { color: '#e5e7eb' } 
          },
          y: { 
            ticks: { color: '#374151' }, 
            grid: { color: '#e5e7eb' }, 
            beginAtZero: true 
          }
        },
        plugins: { 
          legend: { 
            display: false
          } 
        }
      }
    });
  }

  function renderReservationChart(data) {
    const ctx = document.getElementById('reservationChart');
    
    if (reservationChart) {
      reservationChart.destroy();
    }

    reservationChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels || [],
        datasets: [{ 
          label: 'Reservasi', 
          data: data.data || [], 
          backgroundColor: '#f97316', 
          borderRadius: 6,
          borderSkipped: false,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { 
            ticks: { color: '#374151' }, 
            grid: { color: '#e5e7eb' } 
          },
          y: { 
            ticks: { color: '#374151' }, 
            grid: { color: '#e5e7eb' }, 
            beginAtZero: true 
          }
        },
        plugins: { 
          legend: { 
            display: false
          } 
        }
      }
    });
  }

  document.addEventListener('DOMContentLoaded', async () => {
    console.log('🚀 Initializing charts...');
    
    try {
      const orderData = await fetchChartData('order', 'monthly');
      renderOrderChart(orderData);

      const reservationData = await fetchChartData('reservation', 'monthly');
      renderReservationChart(reservationData);
      
      console.log('🎉 All charts initialized successfully');
    } catch (error) {
      console.error('💥 Error initializing charts:', error);
    }
  });

  // Event listeners untuk dropdown
  document.getElementById("orderPeriodSelect").addEventListener("change", async (e) => {
    const period = e.target.value;
    console.log(`🔄 Order period changed to: ${period}`);
    
    try {
      const data = await fetchChartData('order', period);
      renderOrderChart(data);
    } catch (error) {
      console.error('Error updating order chart:', error);
    }
  });

  document.getElementById("reservationPeriodSelect").addEventListener("change", async (e) => {
    const period = e.target.value;
    console.log(`🔄 Reservation period changed to: ${period}`);
    
    try {
      const data = await fetchChartData('reservation', period);
      renderReservationChart(data);
    } catch (error) {
      console.error('Error updating reservation chart:', error);
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

  // Handle window resize untuk responsive charts
  window.addEventListener('resize', function() {
    if (orderChart) {
      orderChart.resize();
    }
    if (reservationChart) {
      reservationChart.resize();
    }
  });
</script>
</body>
</html>