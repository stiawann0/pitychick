<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;

class HomeSettingsController extends Controller
{
    /**
     * Menampilkan data home setting (public API)
     */
    public function index()
    {
        $setting = HomeSetting::first();

        if (!$setting) {
            return response()->json([
                'message' => 'Home setting not found.',
            ], 404);
        }

        return response()->json([
            'title' => $setting->title,
            'description' => $setting->description,
            'background_image_url' => $setting->background_image 
                ? asset('storage/' . $setting->background_image)
                : null,
        ]);
    }

    /**
     * (Opsional) Update home setting – hanya jika kamu ingin support update via API
     */
    public function update(Request $request)
    {
        $this->authorize('manage-settings'); // pakai Gate / Policy untuk proteksi

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'background_image' => 'nullable|image|max:2048',
        ]);

        $setting = HomeSetting::first() ?? new HomeSetting();
        $setting->title = $request->title;
        $setting->description = $request->description;

        if ($request->hasFile('background_image')) {
            if ($setting->background_image && Storage::disk('public')->exists($setting->background_image)) {
                Storage::disk('public')->delete($setting->background_image);
            }

            $path = $request->file('background_image')->store('home_settings', 'public');
            $setting->background_image = $path;
        }

        $setting->save();

        return response()->json([
            'message' => 'Home setting updated successfully.',
            'data' => [
                'title' => $setting->title,
                'description' => $setting->description,
                'background_image_url' => asset('storage/' . $setting->background_image),
            ]
        ]);
    }
}
