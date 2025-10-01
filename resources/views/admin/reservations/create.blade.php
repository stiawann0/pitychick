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
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                                    <input type="text" name="customer_name" id="customer_name" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                    <input type="text" name="customer_phone" id="customer_phone" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="guest_number" class="block text-sm font-medium text-gray-700">Jumlah Tamu</label>
                                    <input type="number" name="guest_number" id="guest_number" min="1" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>
                            </div>

                            <!-- Detail Reservasi -->
                            <div class="space-y-4">
                                <div>
                                    <label for="table_id" class="block text-sm font-medium text-gray-700">Meja</label>
                                    <select name="table_id" id="table_id" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="">Pilih Meja</option>
                                        @foreach($tables as $table)
                                            <option value="{{ $table->id }}">{{ $table->number }} (Kapasitas: {{ $table->capacity }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="reservation_date" class="block text-sm font-medium text-gray-700">Tanggal Reservasi</label>
                                        <input type="date" name="reservation_date" id="reservation_date" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>

                                    <div>
                                        <label for="reservation_time" class="block text-sm font-medium text-gray-700">Jam Reservasi</label>
                                        <input type="time" name="reservation_time" id="reservation_time" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                        </div>

                        <!-- Pemesanan Menu -->
                        <div class="mt-10">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Makanan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($menus as $menu)
                                    <div class="border p-3 rounded-md shadow-sm cursor-pointer menu-item" 
                                         data-menu-id="{{ $menu->id }}" data-quantity="0">
                                        <div class="flex items-center space-x-4">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" 
                                                     alt="{{ $menu->name }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded text-gray-500">
                                                    No Image
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $menu->name }}</p>
                                                <p class="text-sm text-gray-500">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                                                <p class="text-sm text-yellow-600 quantity-display">Jumlah: 0</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="menus[{{ $menu->id }}]" value="0" class="menu-hidden-input">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.reservations.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded mr-2 hover:bg-gray-300 shadow-md">
                                Batal
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-md text-sm font-medium rounded-md text-green-800 bg-green-100 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Simpan Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                let quantity = parseInt(this.dataset.quantity);
                quantity++;
                this.dataset.quantity = quantity;

                this.querySelector('.quantity-display').textContent = 'Jumlah: ' + quantity;
                this.querySelector('.menu-hidden-input').value = quantity;
            });
        });
    });
    </script>
</x-app-layout>
