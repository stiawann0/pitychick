<x-app-layout>
    <x-slot name="title">
        Tambah Pelanggan
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pelanggan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                                <input type="password" name="password" id="password"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.users.index') }}"
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Batal</a>
                            <button type="submit"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-black px-4 py-2 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
