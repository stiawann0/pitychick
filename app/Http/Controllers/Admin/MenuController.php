<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    // ✅ HAPUS middleware constructor, HAPUS Form Request imports

    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    // ✅ GUNAKAN Request biasa, bukan Form Request
    public function store(Request $request)
    {
        try {
            // Validasi manual
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|in:minuman,snack,original,tambahan',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Upload image jika ada
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('menu-images', 'public');
            }

            Menu::create($validated);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Menu creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
        }
    }

    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    // ✅ GUNAKAN Request biasa, bukan Form Request
    public function update(Request $request, Menu $menu)
    {
        try {
            // Validasi manual
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|in:minuman,snack,original,tambahan',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image
                if ($menu->image) {
                    Storage::disk('public')->delete($menu->image);
                }
                // Store new image
                $validated['image'] = $request->file('image')->store('menu-images', 'public');
            }

            $menu->update($validated);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Menu update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            // Delete image if exists
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            
            $menu->delete();

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Menu deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus menu: ' . $e->getMessage());
        }
    }
}