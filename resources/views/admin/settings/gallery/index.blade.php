<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-500 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16l4-4m0 0l4 4m-4-4v12m6-16l4 4m0 0l-4 4m4-4H10" />
            </svg>
            {{ __('Pengaturan Galeri') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Notifikasi --}}
                @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
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

                {{-- Form Upload Galeri --}}
                <form action="{{ route('admin.settings.gallery.store') }}" method="POST" enctype="multipart/form-data" class="mb-10">
                    @csrf
                    <h2 class="text-lg font-semibold mb-4">Tambah Gambar Galeri</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Gambar</label>
                        <input type="file" name="images[]" multiple required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        @error('images.*')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.settings.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-green-600 shadow-md text-sm font-medium rounded-md text-green-800 bg-green-100 hover:bg-green-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Upload
                        </button>
                    </div>
                </form>

                {{-- Daftar Galeri --}}
<h2 class="text-lg font-semibold mb-4">Daftar Gambar Galeri</h2>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse ($images as $image)
        <div class="border rounded-lg shadow-sm relative bg-white overflow-hidden">
    <div class="w-full h-40 relative"> {{-- h-40 = 160px --}}
        <img src="{{ asset('storage/' . $image->image_path) }}"
            class="absolute inset-0 w-full h-full object-cover"
            alt="Gambar Galeri">
        <form action="{{ route('admin.settings.gallery.destroy', $image->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus gambar ini?')"
            class="absolute top-1 right-1 z-10">
            @csrf
            @method('DELETE')
            <button class="bg-white rounded-full p-1 text-red-600 hover:bg-red-600 hover:text-white shadow transition" title="Hapus">
                ✕
            </button>
        </form>
    </div>
</div>

    @empty
        <p class="col-span-full text-gray-600">Belum ada gambar galeri.</p>
    @endforelse
</div>

            </div>
        </div>
    </div>
</x-app-layout>
