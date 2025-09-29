<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Tampilkan daftar meja
    public function index()
    {
        $tables = Table::latest()->paginate(10); // pakai pagination
        return view('admin.tables.index', compact('tables'));
    }

    // Tampilkan form tambah meja
    public function create()
    {
        return view('admin.tables.create');
    }

    // Simpan meja baru
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,maintenance',
        ]);

        Table::create([
            'number' => $request->number,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }


    public function show($id)
{
    $table = Table::findOrFail($id);
    return view('admin.tables.show', compact('table'));
}

    
    // Tampilkan form edit meja
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    // Simpan perubahan meja
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,maintenance',
        ]);

        $table->update([
            'number' => $request->number,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    // Hapus meja
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
