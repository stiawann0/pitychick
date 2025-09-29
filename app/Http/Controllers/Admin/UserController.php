<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Menampilkan daftar pelanggan (tanpa admin)
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan data pelanggan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'customer'; // default role pelanggan

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    // Tampilkan detail pelanggan
    public function show(User $user)
    {
        if ($user->role === 'admin') {
            abort(404); // Admin tidak boleh ditampilkan
        }

        return view('admin.users.show', compact('user'));
    }

    // Form edit pelanggan
    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            abort(404); // Admin tidak boleh diedit dari sini
        }

        return view('admin.users.edit', compact('user'));
    }

    // Update data pelanggan
    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            abort(403); // Admin tidak boleh diubah
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    // Hapus pelanggan
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun admin');
        }

        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Pelanggan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus pelanggan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus pelanggan');
        }
    }
}
