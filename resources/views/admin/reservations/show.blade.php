<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Detail Reservasi</h2>

                    <div class="mb-4">
                        <strong>Nama Pelanggan:</strong> {{ $reservation->customer_name }}
                    </div>

                    <div class="mb-4">
                        <strong>Email Pelanggan:</strong> {{ $reservation->customer_email ?? '-' }}
                    </div>

                    <div class="mb-4">
                        <strong>No. Telepon Pelanggan:</strong> {{ $reservation->customer_phone ?? '-' }}
                    </div>

                    <div class="mb-4">
                        <strong>Tanggal Reservasi:</strong>
                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                    </div>

                    <div class="mb-4">
                        <strong>Waktu Reservasi:</strong>
                        {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                    </div>

                    <div class="mb-4">
                        <strong>Meja:</strong> {{ $reservation->table->name ?? '-' }}
                    </div>

                    <div class="mb-4">
                        <strong>Jumlah Tamu:</strong> {{ $reservation->guest_number }}
                    </div>

                    <div class="mb-4">
                        <strong>Status:</strong>
                        <span @class([
                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                            'bg-yellow-100 text-yellow-800' => $reservation->status === 'pending',
                            'bg-green-100 text-green-800' => $reservation->status === 'confirmed',
                            'bg-red-100 text-red-800' => $reservation->status === 'cancelled'
                        ])>
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('admin.reservations.edit', $reservation) }}"
                            class="bg-yellow-600 hover:bg-yellow-700 text-black px-4 py-2 rounded shadow">
                            Edit
                        </a>
                        <a href="{{ route('admin.reservations.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
