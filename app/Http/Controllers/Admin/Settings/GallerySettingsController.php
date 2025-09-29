<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GallerySettingsController extends Controller
{
    public function index()
    {
        $images = Gallery::all();
        return view('admin.settings.gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('gallery', 'public');
                Gallery::create(['image_path' => $path]);
            }
        }

        return back()->with('success', 'Gambar berhasil ditambahkan');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
