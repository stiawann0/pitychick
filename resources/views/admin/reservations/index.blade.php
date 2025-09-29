@extends('layouts.admin')

@section('title', 'Daftar Reservasi')
@section('header-title', 'Manajemen Reservasi')

@section('content')
<div class="bg-white shadow-sm rounded-lg mb-6">
    <div class="p-6 flex justify-between items-center border-b">
        <h3 class="text-lg font-semibold">Daftar Reservasi</h3>
        <a href="{{ route('admin.reservations.create') }}" class="bg-yellow-600 hover:bg-yellow-700 text-black px-4 py-2 rounded flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Reservasi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="overflow-x-auto bg-white shadow-sm rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal/Waktu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($reservations as $reservation)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $reservation->customer_name }}</div>
                    <div class="text-sm text-gray-500">{{ $reservation->customer_email }}</div>
                    <div class="text-sm text-gray-500">{{ $reservation->customer_phone }}</div>
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
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $reservation->guest_number }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span @class([
                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                        'bg-yellow-100 text-yellow-800' => $reservation->status === 'pending',
                        'bg-green-100 text-green-800' => $reservation->status === 'confirmed',
                        'bg-red-100 text-red-800' => $reservation->status === 'cancelled'
                    ])>
                        {{ ucfirst($reservation->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($reservation->payment_status === 'paid')
                        <span class="text-green-600 font-semibold">Lunas</span>
                    @else
                        <span class="text-red-600 font-semibold">Belum Bayar</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3">
                        <!-- Edit -->
                        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Reservasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <!-- Bayar -->
                        @if($reservation->payment_status === 'unpaid' && $reservation->snap_token)
                        <button 
                            type="button" 
                            onclick="pay('{{ $reservation->snap_token }}')" 
                            class="text-blue-600 hover:text-blue-900" 
                            title="Bayar Sekarang">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                            </svg>
                        </button>
                        @endif

                        <!-- Konfirmasi -->
                        @if($reservation->status === 'pending')
                        <form action="{{ route('admin.reservations.confirm', $reservation) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900" title="Konfirmasi Reservasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </form>
                        @endif

                        <!-- Batalkan -->
                        @if($reservation->status !== 'cancelled')
                        <form action="{{ route('admin.reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Batalkan Reservasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                    Tidak ada reservasi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $reservations->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function pay(snapToken) {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                location.reload();
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
                location.reload();
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
            },
            onClose: function() {
                alert("Transaksi dibatalkan.");
            }
        });
    }
</script>
@endsection
