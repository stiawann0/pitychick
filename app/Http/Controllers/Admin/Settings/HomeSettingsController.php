<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-settings');
    }

    /**
     * Tampilkan halaman pengaturan home
     */
    public function index()
    {
        $setting = HomeSetting::first();
        return view('admin.settings.homesettings.index', compact('setting'));
    }

    /**
     * Update data pengaturan home
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'background_image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $setting = HomeSetting::first() ?? new HomeSetting();

            $setting->title = $request->title;
            $setting->description = $request->description;

            if ($request->hasFile('background_image')) {
                // Hapus gambar lama (jika ada)
                if ($setting->background_image && Storage::disk('public')->exists($setting->background_image)) {
                    Storage::disk('public')->delete($setting->background_image);
                }

                // Simpan gambar baru
                $path = $request->file('background_image')->store('home_images', 'public');
                $setting->background_image = $path;
            }

            $setting->save();

            DB::commit();

            return redirect()->route('admin.settings.home')->with('success', 'Pengaturan homepage berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui pengaturan home: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengaturan.');
        }
    }
}
