<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 10h18M4 10v10m16-10v10M8 10v10m8-10v10" />
            </svg>
            {{ __('Tambah Meja') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
<h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
    
    Pity Chick
</h3>
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.tables.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="number" class="block text-sm font-medium text-gray-700">Nomor Meja</label>
<input type="text" name="number" id="number" value="{{ old('number') }}" required
       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">

                        </div>

                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Kapasitas</label>
                            <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity') }}" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.tables.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-yellow-600 shadow-md text-sm font-medium rounded-md text-green-800 bg-green-100 hover:bg-green-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Simpan Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
