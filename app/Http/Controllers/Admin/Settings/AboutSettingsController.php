<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AboutSettingsController extends Controller
{
    public function index()
    {
        $about = DB::table('about_settings')->first();
        return view('admin.settings.aboutsettings.index', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description_1' => 'required|string',
            'description_2' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'story_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $about = AboutSetting::first() ?? new AboutSetting();

            $about->title = $request->title;
            $about->description_1 = $request->description_1;
            $about->description_2 = $request->description_2;

            // GUNAKAN STORAGE BUKAN PUBLIC DIRECTORY
            if ($request->hasFile('main_image')) {
                // Hapus gambar lama jika ada
                if ($about->main_image && Storage::exists('public/about-images/' . basename($about->main_image))) {
                    Storage::delete('public/about-images/' . basename($about->main_image));
                }

                // Simpan ke storage
                $mainImage = $request->file('main_image');
                $mainImageName = uniqid() . '.' . $mainImage->getClientOriginalExtension();
                $mainImagePath = $mainImage->storeAs('public/about-images', $mainImageName);
                
                // Simpan path relative untuk database
                $about->main_image = 'about-images/' . $mainImageName;
            }

            if ($request->hasFile('story_image')) {
                // Hapus gambar lama jika ada
                if ($about->story_image && Storage::exists('public/about-images/' . basename($about->story_image))) {
                    Storage::delete('public/about-images/' . basename($about->story_image));
                }

                // Simpan ke storage
                $storyImage = $request->file('story_image');
                $storyImageName = uniqid() . '.' . $storyImage->getClientOriginalExtension();
                $storyImagePath = $storyImage->storeAs('public/about-images', $storyImageName);
                
                // Simpan path relative untuk database
                $about->story_image = 'about-images/' . $storyImageName;
            }

            $about->save();

            DB::commit();

            return redirect()->back()->with('success', 'Pengaturan Tentang Kami berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui About Setting: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}