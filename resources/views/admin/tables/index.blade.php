@extends('layouts.admin')

@section('title', 'Kelola Meja')

@section('content')
<div class="bg-white shadow-sm rounded-lg mb-6">
    <div class="p-6 flex justify-between items-center border-b">
        <h3 class="text-lg font-semibold">Daftar Meja</h3>
            <a href="{{ route('admin.tables.create') }}" class="bg-yellow-600 hover:bg-yellow-700 text-black px-4 py-2 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Meja
            </a>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Meja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($tables as $table)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $table->number }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $table->capacity }} orang</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($table->status == 'available')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Tersedia
                    </span>
                    @elseif($table->status == 'reserved')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Dipesan
                    </span>
                    @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Maintenance
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3">
                        <!-- Tombol Show -->
                        <a href="{{ route('admin.tables.show', $table->id) }}" class="text-blue-600 hover:text-blue-900" title="Detail Meja">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <div class="px-1"></div> 
                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.tables.edit', $table->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Meja">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <div class="px-1"></div> 
                        <!-- Tombol Delete -->
                        <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus Meja">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection