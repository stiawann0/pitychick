<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;

class AboutSettingsController extends Controller
{
    public function index()
    {
        $about = AboutSetting::first();
        if (!$about) {
            return response()->json([
                'title' => 'About PITY Chick',
                'description_1' => 'Welcome to PITY Chick restaurant.',
                'description_2' => 'We serve quality food with passion.',
                'main_image' => null,
                'story_image' => null,
                'main_image_url' => null,
                'story_image_url' => null
            ]);
        }

        // Return dengan full URLs seperti Home settings
        return response()->json([
            'id' => $about->id,
            'title' => $about->title,
            'description_1' => $about->description_1,
            'description_2' => $about->description_2,
            'main_image' => $about->main_image,
            'story_image' => $about->story_image,
            // TAMBAHKAN FULL URLs seperti Home
            'main_image_url' => $about->main_image ? asset('storage/' . $about->main_image) : null,
            'story_image_url' => $about->story_image ? asset('storage/' . $about->story_image) : null,
            'created_at' => $about->created_at,
            'updated_at' => $about->updated_at
        ]);
    }
}