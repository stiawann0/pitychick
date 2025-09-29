<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReviewSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-settings');
    }

    /**
     * Tampilkan semua review
     */
    public function index()
    {
        $reviews = Review::all();
        return view('admin.settings.reviewsettings.index', compact('reviews'));
    }

    /**
     * Simpan review baru
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'required|string',
        'image' => 'required|image|max:2048',
    ]);

    try {
        DB::beginTransaction();

        // Upload file ke storage/app/public/review
        $path = $request->file('image')->store('review', 'public');

        // Simpan path publik ke database
        Review::create([
            'name' => $request->name,
            'description' => $request->description,
            'img' => 'storage/' . $path, // contoh: storage/review/namafile.jpg
        ]);

        DB::commit();
        return back()->with('success', 'Review berhasil ditambahkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menambahkan review: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Gagal menambahkan review.');
    }
}


    /**
     * Hapus review berdasarkan ID
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $review = Review::findOrFail($id);

            if ($review->img && Storage::disk('public')->exists(str_replace('storage/', '', $review->img))) {
    Storage::disk('public')->delete(str_replace('storage/', '', $review->img));
}


            $review->delete();

            DB::commit();
            return back()->with('success', 'Review berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus review: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus review.');
        }
    }
}
