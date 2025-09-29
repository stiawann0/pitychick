<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GallerySettingsController extends Controller
{
    /**
     * Tampilkan semua gambar galeri.
     */
    public function index()
    {
        // Ambil semua gambar dan ubah path-nya agar bisa diakses publik
        $images = Gallery::all()->map(function ($item) {
            return asset('storage/' . $item->image_path);
        });

        return response()->json($images);
    }
}
