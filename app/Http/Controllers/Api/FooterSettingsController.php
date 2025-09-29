<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Support\Facades\Log;

class FooterSettingsController extends Controller
{
    public function index()
    {
        try {
            $footer = FooterSetting::first();

            if (!$footer) {
                return response()->json(['message' => 'Footer settings not found'], 404);
            }

            $response = [
                'brand_name' => $footer->brand_name,
                'brand_description' => $footer->brand_description,
                'email' => $footer->email,
                'phone' => $footer->phone,
                'instagram' => $footer->instagram,
                'address' => $footer->address,
                'footer_note' => $footer->footer_note ?? '',
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Footer API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
