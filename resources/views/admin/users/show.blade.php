<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.389 0 4.61.588 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v6"/>
                    </svg>
                    Informasi Pelanggan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Nama</p>
                        <p class="text-gray-800">{{ $user->name }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Email</p>
                        <p class="text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-500">Telepon</p>
                        <p class="text-gray-800">{{ $user->phone }}</p>
                    </div>
                </div>

                <div class="mt-8 p-4">
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded hover:bg-blue-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Daftar Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
