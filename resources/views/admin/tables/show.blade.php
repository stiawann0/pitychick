<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            {{ __('Detail Meja') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    
                    Pity Chick
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Nama Meja</p>
                        <p class="text-gray-800">{{ $table->number }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Kapasitas</p>
                        <p class="text-gray-800">{{ $table->capacity }} orang</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Status</p>
                        <p class="text-gray-800">
                            @if($table->status == 'available')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-800 font-semibold">Tersedia</span>
                            @elseif($table->status == 'reserved')
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 font-semibold">Dipesan</span>
                            @else
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 font-semibold">Maintenance</span>
                            @endif
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Dibuat Pada</p>
                        <p class="text-gray-800">{{ $table->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Terakhir Diubah</p>
                        <p class="text-gray-800">{{ $table->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="mt-8 p-4">
                    <a href="{{ route('admin.tables.index') }}"
                       class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded hover:bg-yellow-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Daftar Meja
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
