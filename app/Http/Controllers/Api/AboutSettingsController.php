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
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($about);
    }
}

