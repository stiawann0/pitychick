<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ __('Buat Reservasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Pity Chick - Form Reservasi
                    </h3>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.reservations.store') }}" method="POST">
                        @csrf
                        
                        <!-- Informasi Pelanggan -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                Informasi Pelanggan
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Pelanggan *
                                    </label>
                                    <input type="text" name="customer_name" id="customer_name" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_name') }}"
                                        placeholder="Masukkan nama lengkap">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email *
                                    </label>
                                    <input type="email" name="customer_email" id="customer_email" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_email') }}"
                                        placeholder="email@example.com">
                                    @error('customer_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        No. Telepon *
                                    </label>
                                    <input type="text" name="customer_phone" id="customer_phone" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_phone') }}"
                                        placeholder="08xxxxxxxxxx">
                                    @error('customer_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="guest_count" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Tamu *
                                    </label>
                                    <input type="number" name="guest_count" id="guest_count" min="1" max="20" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('guest_count', 2) }}"
                                        placeholder="Jumlah tamu">
                                    @error('guest_count')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Detail Reservasi -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                Detail Reservasi
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="table_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih Meja *
                                    </label>
                                    <select name="table_id" id="table_id" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="">-- Pilih Meja --</option>
                                        @foreach($tables as $table)
                                            <option value="{{ $table->id }}" 
                                                {{ old('table_id') == $table->id ? 'selected' : '' }}
                                                class="{{ $table->status !== 'available' ? 'text-red-500' : '' }}">
                                                Meja {{ $table->number }} 
                                                (Kapasitas: {{ $table->capacity }})
                                                {{ $table->status !== 'available' ? ' - TIDAK TERSEDIA' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-sm text-gray-500 mt-1">Hanya meja dengan status tersedia yang bisa dipilih</p>
                                    @error('table_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal *
                                        </label>
                                        <input type="date" name="reservation_date" id="reservation_date" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                            value="{{ old('reservation_date') }}"
                                            min="{{ date('Y-m-d') }}">
                                        @error('reservation_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="reservation_time" class="block text-sm font-medium text-gray-700 mb-2">
                                            Jam *
                                        </label>
                                        <input type="time" name="reservation_time" id="reservation_time" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                            value="{{ old('reservation_time', '18:00') }}">
                                        @error('reservation_time')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Khusus -->
                        <div class="mb-8">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Khusus (Opsional)
                            </label>
                            <textarea name="special_requests" id="special_requests" rows="4"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Contoh: Meja dekat jendela, ada alergi makanan tertentu, dll.">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informasi -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-yellow-800">
                                        <strong>Note:</strong> Reservasi ini hanya untuk pemesanan tempat. 
                                        Pesanan makanan/minuman dapat dilakukan langsung di restoran.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end space-x-4 pt-6 border-t">
                            <a href="{{ route('admin.reservations.index') }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200 font-medium shadow-sm flex items-center">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Buat Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation_date').min = today;
        
        // Set default date to today if empty
        if (!document.getElementById('reservation_date').value) {
            document.getElementById('reservation_date').value = today;
        }
        
        // Filter hanya meja yang available
        const tableSelect = document.getElementById('table_id');
        const options = tableSelect.options;
        
        for (let i = 0; i < options.length; i++) {
            if (options[i].textContent.includes('TIDAK TERSEDIA')) {
                options[i].disabled = true;
            }
        }
    });
    </script>
</x-app-layout>