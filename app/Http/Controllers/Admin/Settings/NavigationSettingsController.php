<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\NavigationSetting;
use Illuminate\Http\Request;

class NavigationSettingsController extends Controller
{
    public function index()
    {
        // Mungkin mau filter yang aktif saja? Contoh:
        $navigations = NavigationSetting::where('is_active', true)
            ->orderBy('position')
            ->get();

        return view('admin.settings.navigationsettings.index', compact('navigations'));
    }

    public function create()
    {
        return view('admin.settings.navigationsettings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => ['required', 'regex:/^(#|\/|https?:\/\/).+/'],
            'position' => 'nullable|integer',
            'role' => 'required|in:admin,user,all',
            'is_active' => 'nullable|boolean',
        ]);

        // Pastikan is_active di-set default, kalau tidak diisi
        $data = $request->only('label', 'url', 'position', 'role', 'is_active');
        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        NavigationSetting::create($data);

        return redirect()->route('admin.settings.navigation.index')
            ->with('success', 'Navigasi berhasil ditambahkan.');
    }

    public function update(Request $request, NavigationSetting $navigation)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => ['required', 'regex:/^(#|\/|https?:\/\/).+/'],
            'position' => 'nullable|integer',
            'role' => 'required|in:admin,user,all',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only('label', 'url', 'position', 'role', 'is_active');
        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        $navigation->update($data);

        return redirect()->route('admin.settings.navigation.index')
            ->with('success', 'Navigasi berhasil diperbarui.');
    }

    public function destroy(NavigationSetting $navigation)
    {
        $navigation->delete();

        return redirect()->route('admin.settings.navigation.index')
            ->with('success', 'Navigasi berhasil dihapus.');
    }
}