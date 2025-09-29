<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(StoreMenuRequest $request)
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('menu-images', 'public');
            }

            Menu::create($data);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Menu creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan menu');
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

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                if ($menu->image) {
                    Storage::disk('public')->delete($menu->image);
                }
                $data['image'] = $request->file('image')->store('menu-images', 'public');
            }

            $menu->update($data);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Menu update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui menu');
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            
            $menu->delete();

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Menu deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus menu');
        }
    }
}