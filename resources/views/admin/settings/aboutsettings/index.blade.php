<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
            </svg>
            {{ __('Pengaturan Tentang Kami') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

                <form action="{{ route('admin.settings.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $about->title ?? '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                            required>
                        @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Utama</label>
                        <textarea name="description_1" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                            required>{{ old('description_1', $about->description_1 ?? '') }}</textarea>
                        @error('description_1')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Cerita (Opsional)</label>
                        <textarea name="description_2" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                            >{{ old('description_2', $about->description_2 ?? '') }}</textarea>
                        @error('description_2')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Utama (opsional)</label>
                        <input type="file" name="main_image"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        @if(!empty($about->main_image))
                            <div class="mt-3">
                                <!-- GUNAKAN asset('storage/') seperti Home -->
                                <img src="{{ asset('storage/' . $about->main_image) }}" alt="Main Image" class="w-40 h-40 rounded-md border shadow">
                            </div>
                        @endif
                        @error('main_image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Cerita (opsional)</label>
                        <input type="file" name="story_image"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        @if(!empty($about->story_image))
                            <div class="mt-3">
                                <!-- GUNAKAN asset('storage/') seperti Home -->
                                <img src="{{ asset('storage/' . $about->story_image) }}" alt="Story Image" class="w-40 h-40 rounded-md border shadow">
                            </div>
                        @endif
                        @error('story_image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-yellow-600 shadow-md text-sm font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>