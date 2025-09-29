<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Pity Chick') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pengaturan Website -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pengaturan Website</h3>
                        @can('manage-settings')
                            <a href="{{ route('admin.settings.index') }}" class="text-blue-600 text-sm font-medium hover:underline">Lihat semua</a>
                        @endcan
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                    <!-- Home Settings -->
                    <div class="bg-gray-50 overflow-hidden border border-gray-200 shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-base font-bold text-gray-800">Pengaturan Beranda</h3>
                                <p class="text-gray-500 text-sm font-medium">Home Settings</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="px-6 pb-4">
                        @can('manage-settings')
                            <a href="{{ route('admin.settings.home') }}" class="text-green-600 text-sm font-medium hover:underline flex items-center">
                                Kelola
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                        @endcan
                    </div>
                </div>

                <!-- About Settings -->
                <div class="bg-gray-50 overflow-hidden border border-gray-200 shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-base font-bold text-gray-800">Pengaturan About</h3>
                            <p class="text-gray-500 text-sm font-medium">About Settings</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 12h.01M9 16h.01M15 16h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-4">
                    @can('manage-settings')
                        <a href="{{ route('admin.settings.about') }}" class="text-red-600 text-sm font-medium hover:underline flex items-center">
                            Kelola
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>

            <!-- Review Settings -->
            <div class="bg-gray-50 overflow-hidden border border-gray-200 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Pengaturan Review</h3>
                        <p class="text-gray-500 text-sm font-medium">Review Settings</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.39 2.462a1 1 0 00-.364 1.118l1.287 3.974c.3.921-.755 1.688-1.538 1.118l-3.39-2.462a1 1 0 00-1.176 0l-3.39 2.462c-.783.57-1.838-.197-1.538-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.049 9.4c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.974z" />
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-settings')
                    <a href="{{ route('admin.settings.reviews') }}" class="text-blue-600 text-sm font-medium hover:underline flex items-center">
                        Kelola
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>

            <!-- Gallery Settings -->
            <div class="bg-gray-50 overflow-hidden border border-gray-200 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Pengaturan Galeri</h3>
                        <p class="text-gray-500 text-sm font-medium">Gallery Settings</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h18M3 19h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-settings')
                    <a href="{{ route('admin.settings.gallery') }}" class="text-yellow-600 text-sm font-medium hover:underline flex items-center">
                        Kelola
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>



            <!-- Footer Settings -->
            <div class="bg-gray-50 overflow-hidden border border-gray-200 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Pengaturan Footer</h3>
                        <p class="text-gray-500 text-sm font-medium">Footer Settings</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h18M9 3v2m6-2v2M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-settings')
                    <a href="{{ route('admin.settings.footer') }}" class="text-indigo-600 text-sm font-medium hover:underline flex items-center">
                        Kelola
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Reservasi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Reservasi</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalReservations }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-4">
                    @can('manage-reservations')
                        <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 text-sm font-medium hover:underline flex items-center">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>

            <!-- Card Meja Tersedia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Meja Tersedia</h3>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $availableTables }} <span class="text-sm font-normal text-gray-500">/ {{ $totalTables }} total</span>
                        </p>    
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M4 10v10m16-10v10M8 10v4m8-4v4" />
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-tables')
                    <a href="{{ route('admin.tables.index') }}" class="text-green-600 hover:underline text-sm font-medium flex items-center">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>

            <!-- Total Menu -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Menu</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalMenus }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6c0-1.1-.9-2-2-2H5a2 2 0 00-2 2v13a1 1 0 001.45.89L10 18.118M12 6c0-1.1.9-2 2-2h5a2 2 0 012 2v13a1 1 0 01-1.45.89L14 18.118M12 6v12" />
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-menus')
                    <a href="{{ route('admin.menus.index') }}" class="text-yellow-600 text-sm font-medium hover:underline flex items-center">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Pelanggan</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="px-6 pb-4">
                    @can('manage-users')
                    <a href="{{ route('admin.users.index') }}" class="text-purple-600 text-sm font-medium hover:underline flex items-center">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                        <span class="text-gray-400 text-sm">Hanya untuk admin</span>
                    @endcan
                </div>
            </div>
        </div>
            

            
            <!-- Reservasi Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Reservasi Terbaru</h3>
                        @can('manage-reservations')
                        <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 text-sm font-medium hover:underline">Lihat semua</a>
                        @endcan
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentReservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $reservation->customer_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $reservation->customer_email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->formatted_reservation_date }}</div>
                                        <div class="text-sm text-gray-500">{{ $reservation->formatted_reservation_time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $reservation->table->number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            'bg-green-100 text-green-800' => $reservation->status === 'confirmed',
                                            'bg-yellow-100 text-yellow-800' => $reservation->status === 'pending',
                                            'bg-red-100 text-red-800' => $reservation->status === 'cancelled'
                                        ])>
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada reservasi terbaru
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Reservasi</h3>
                        <canvas id="reservationChart" height="200"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Reservasi Per Bulan</h3>
                        <canvas id="monthlyChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Status Reservasi
        document.addEventListener('DOMContentLoaded', function() {
            const reservationCtx = document.getElementById('reservationChart')?.getContext('2d');
            if (reservationCtx) {
                new Chart(reservationCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Dikonfirmasi', 'Menunggu', 'Dibatalkan'],
                        datasets: [{
                            data: [
                                {{ $reservationStats['confirmed'] ?? 0 }},
                                {{ $reservationStats['pending'] ?? 0 }},
                                {{ $reservationStats['cancelled'] ?? 0 }}
                            ],
                            backgroundColor: [
                                '#10B981',
                                '#F59E0B',
                                '#EF4444'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }

            // Grafik Bulanan
            const monthlyCtx = document.getElementById('monthlyChart')?.getContext('2d');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Reservasi',
                            data: [
                                {{ $monthlyReservations[1] ?? 0 }},
                                {{ $monthlyReservations[2] ?? 0 }},
                                {{ $monthlyReservations[3] ?? 0 }},
                                {{ $monthlyReservations[4] ?? 0 }},
                                {{ $monthlyReservations[5] ?? 0 }},
                                {{ $monthlyReservations[6] ?? 0 }},
                                {{ $monthlyReservations[7] ?? 0 }},
                                {{ $monthlyReservations[8] ?? 0 }},
                                {{ $monthlyReservations[9] ?? 0 }},
                                {{ $monthlyReservations[10] ?? 0 }},
                                {{ $monthlyReservations[11] ?? 0 }},
                                {{ $monthlyReservations[12] ?? 0 }}
                            ],
                            backgroundColor: '#3B82F6'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
    
</x-app-layout>