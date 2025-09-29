<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ __('Edit Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informasi Pelanggan -->
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                                    <input type="text" name="customer_name" id="customer_name" required
                                        value="{{ old('customer_name', $reservation->customer_name) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" required
                                        value="{{ old('customer_email', $reservation->customer_email) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                    <input type="text" name="customer_phone" id="customer_phone" required
                                        value="{{ old('customer_phone', $reservation->customer_phone) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                </div>

                                <div>
                                    <label for="guest_number" class="block text-sm font-medium text-gray-700">Jumlah Tamu</label>
                                    <input type="number" name="guest_number" id="guest_number" min="1" required
                                        value="{{ old('guest_number', $reservation->guest_number) }}"
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
                                            <option value="{{ $table->id }}" {{ $reservation->table_id == $table->id ? 'selected' : '' }}>
                                                {{ $table->number }} (Kapasitas: {{ $table->capacity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="reservation_date" class="block text-sm font-medium text-gray-700">Tanggal Reservasi</label>
                                        <input type="date" name="reservation_date" id="reservation_date" required
                                            value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>

                                    <div>
                                        <label for="reservation_time" class="block text-sm font-medium text-gray-700">Jam Reservasi</label>
                                        <input type="time" name="reservation_time" id="reservation_time" required
                                            value="{{ old('reservation_time', $reservation->reservation_time->format('H:i')) }}"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">{{ old('notes', $reservation->notes) }}</textarea>
                        </div>

                        <!-- Tombol Simpan & Bayar -->
                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="{{ route('admin.reservations.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 shadow-md">
                                Batal
                            </a>

                            <!-- Bayar Sekarang -->
                            <button type="submit" name="payment_option" value="now"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 shadow-md font-semibold">
                                Bayar Sekarang
                            </button>

                            <!-- Bayar Nanti -->
                            <button type="submit" name="payment_option" value="later"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 shadow-md font-semibold">
                                Bayar Nanti
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
