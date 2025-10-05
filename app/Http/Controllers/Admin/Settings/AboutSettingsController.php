<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSetting;
use Illuminate\Support\Facades\DB;

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

        $destinationPath = public_path('about-images');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('main_image')) {
            if ($about->main_image && file_exists(public_path($about->main_image))) {
                unlink(public_path($about->main_image));
            }

            $mainImage = $request->file('main_image');
            $mainImageName = uniqid() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move($destinationPath, $mainImageName);
            $about->main_image = 'about-images/' . $mainImageName;
        }

        if ($request->hasFile('story_image')) {
            if ($about->story_image && file_exists(public_path($about->story_image))) {
                unlink(public_path($about->story_image));
            }

            $storyImage = $request->file('story_image');
            $storyImageName = uniqid() . '.' . $storyImage->getClientOriginalExtension();
            $storyImage->move($destinationPath, $storyImageName);
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