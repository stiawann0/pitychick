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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">Pity Chick</h3>

                    <form action="{{ route('admin.reservations.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informasi Pelanggan -->
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Pelanggan *</label>
                                    <input type="text" name="customer_name" id="customer_name" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" name="customer_email" id="customer_email" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_email') }}">
                                    @error('customer_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">No. Telepon *</label>
                                    <input type="text" name="customer_phone" id="customer_phone" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="guest_count" class="block text-sm font-medium text-gray-700">Jumlah Tamu *</label>
                                    <input type="number" name="guest_count" id="guest_count" min="1" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                        value="{{ old('guest_count') }}">
                                    @error('guest_count')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Detail Reservasi -->
                            <div class="space-y-4">
                                <div>
                                    <label for="table_id" class="block text-sm font-medium text-gray-700">Meja *</label>
                                    <select name="table_id" id="table_id" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="">Pilih Meja</option>
                                        @foreach($tables as $table)
                                            <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                                {{ $table->number }} (Kapasitas: {{ $table->capacity }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('table_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="reservation_date" class="block text-sm font-medium text-gray-700">Tanggal Reservasi *</label>
                                        <input type="date" name="reservation_date" id="reservation_date" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                            value="{{ old('reservation_date') }}">
                                        @error('reservation_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="reservation_time" class="block text-sm font-medium text-gray-700">Jam Reservasi *</label>
                                        <input type="time" name="reservation_time" id="reservation_time" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                            value="{{ old('reservation_time') }}">
                                        @error('reservation_time')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mt-6">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Permintaan Khusus</label>
                            <textarea name="special_requests" id="special_requests" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pemesanan Menu -->
                        <div class="mt-10">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Makanan/Minuman</h4>
                            <p class="text-sm text-gray-600 mb-4">Klik pada menu untuk menambah jumlah pesanan</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($menus as $menu)
                                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition-colors menu-item" 
                                         data-menu-id="{{ $menu->id }}">
                                        <div class="flex items-start space-x-3">
                                            @if($menu->image)
                                                <img src="{{ Storage::disk('public')->url($menu->image) }}" 
                                                     alt="{{ $menu->name }}" 
                                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500 flex-shrink-0">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-800">{{ $menu->name }}</h5>
                                                <p class="text-sm text-gray-600 mb-1">{{ Str::limit($menu->description, 50) }}</p>
                                                <p class="text-yellow-600 font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="text-sm text-gray-500 quantity-display">Jumlah: 0</span>
                                                    <div class="flex items-center space-x-2">
                                                        <button type="button" class="minus-btn w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-300" 
                                                                onclick="updateQuantity({{ $menu->id }}, -1)">-</button>
                                                        <button type="button" class="plus-btn w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center text-white hover:bg-yellow-600" 
                                                                onclick="updateQuantity({{ $menu->id }}, 1)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="menus[{{ $menu->id }}]" value="0" class="menu-input" id="menu-input-{{ $menu->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.reservations.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    function updateQuantity(menuId, change) {
        const input = document.getElementById(`menu-input-${menuId}`);
        const display = document.querySelector(`[data-menu-id="${menuId}"] .quantity-display`);
        
        let currentQuantity = parseInt(input.value) || 0;
        let newQuantity = currentQuantity + change;
        
        // Pastikan tidak kurang dari 0
        if (newQuantity < 0) newQuantity = 0;
        
        input.value = newQuantity;
        display.textContent = `Jumlah: ${newQuantity}`;
        
        // Update style berdasarkan quantity
        const menuItem = document.querySelector(`[data-menu-id="${menuId}"]`);
        if (newQuantity > 0) {
            menuItem.classList.add('bg-yellow-50', 'border-yellow-300');
        } else {
            menuItem.classList.remove('bg-yellow-50', 'border-yellow-300');
        }
    }

    // Initialize quantities
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation_date').min = today;
    });
    </script>

    <style>
    .menu-item {
        transition: all 0.2s ease-in-out;
    }
    .menu-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    </style>
</x-app-layout>