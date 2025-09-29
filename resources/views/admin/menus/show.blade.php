<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            {{ __('Detail Menu') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">                   
                    Pity Chick
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                    <!-- Gambar Menu -->
                    <div class="bg-gray-50 p-4 rounded-lg flex justify-center items-center">
                        @if($menu->image)
                        <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}"
                             class="w-full h-64 object-cover rounded-lg">
                        @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Informasi Detail Menu -->
                    <div>
    <div class="p-4 bg-gray-50 rounded-lg mb-6">
        <p class="font-medium text-gray-500">Nama Menu</p>
        <p class="text-gray-800 text-lg font-semibold">{{ $menu->name }}</p>
    </div>
    <div class="p-4 bg-gray-50 rounded-lg mb-6">
        <p class="font-medium text-gray-500">Kategori</p>
        <p class="text-gray-800 capitalize">
            {{ $menu->category }}
        </p>
    </div>
    <div class="p-4 bg-gray-50 rounded-lg mb-6">
        <p class="font-medium text-gray-500">Harga</p>
        <p class="text-gray-800 font-semibold text-lg">
            Rp {{ number_format($menu->price, 0, ',', '.') }}
        </p>
    </div>
    <div class="p-4 bg-gray-50 rounded-lg">
        <p class="font-medium text-gray-500">Deskripsi</p>
        <p class="text-gray-800">{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>
    </div>
</div>

                </div>

                <div class="mt-8 p-4">
                    <a href="{{ route('admin.menus.index') }}"
                       class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded hover:bg-blue-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Daftar Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
