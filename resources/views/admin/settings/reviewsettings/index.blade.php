<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553 2.276A1 1 0 0120 13.118V18a1 1 0 01-1 1H5a1 1 0 01-1-1v-4.882a1 1 0 01.447-.842L9 10m6 0V6a3 3 0 00-6 0v4m6 0H9" />
            </svg>
            {{ __('Pengaturan Review') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 text-red-600">{{ session('error') }}</div>
                @endif

                {{-- Menampilkan Semua Error --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Tambah Review --}}
                <form action="{{ route('admin.settings.reviews.store') }}" method="POST" enctype="multipart/form-data" class="mb-10">
                    @csrf
                    <h2 class="text-lg font-semibold mb-4">Tambah Review Baru</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" name="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-yellow-600 shadow-md text-sm font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Simpan
                        </button>
                    </div>
                </form>

                {{-- Daftar Review --}}
                <h2 class="text-lg font-semibold mb-4">Daftar Review</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($reviews as $review)
                        <div class="border rounded-lg p-4 shadow-sm relative">
                            <img src="{{ asset($review->img) }}" alt="{{ $review->name }}" class="w-full h-40 object-cover rounded mb-3">
                            <h3 class="text-md font-bold">{{ $review->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $review->description }}</p>

                            <form action="{{ route('admin.settings.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?')" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm" title="Hapus">✕</button>
                            </form>
                        </div>
                    @empty
                        <p class="col-span-3 text-gray-600">Belum ada review.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
