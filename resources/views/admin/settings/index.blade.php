@extends('layouts.admin')

@section('title', 'Kelola Pengaturan Website')

@section('content')
<div class="bg-white shadow-sm rounded-lg mb-6">
    <div class="p-6 flex justify-between items-center border-b">
        <h3 class="text-lg font-semibold">Daftar Pengaturan Website</h3>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengaturan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @php
                $settings = [
                    ['title' => 'Pengaturan Beranda', 'desc' => 'Home Settings', 'route' => 'admin.settings.home'],
                    ['title' => 'Pengaturan About', 'desc' => 'About Settings', 'route' => 'admin.settings.about'],
                    ['title' => 'Pengaturan Review', 'desc' => 'Review Settings', 'route' => 'admin.settings.reviews'],
                    ['title' => 'Pengaturan Footer', 'desc' => 'Footer Settings', 'route' => 'admin.settings.footer'],
                    ['title' => 'Pengaturan Galeri', 'desc' => 'Gallery Settings', 'route' => 'admin.settings.gallery'],
                ];
            @endphp

            @foreach ($settings as $index => $setting)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $setting['title'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $setting['desc'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route($setting['route']) }}" class="text-indigo-600 hover:underline">Kelola</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
