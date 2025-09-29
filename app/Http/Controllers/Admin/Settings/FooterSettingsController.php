<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FooterSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-settings');
    }

    /**
     * Tampilkan halaman pengaturan footer
     */
    public function index()
    {
        $footer = FooterSetting::first();
        return view('admin.settings.footersettings.index', compact('footer'));
    }

    /**
     * Simpan/update data pengaturan footer
     */
    public function update(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_description' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'instagram' => 'nullable|string',
            'address' => 'nullable|string',
            'footer_note' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $footer = FooterSetting::first();

            if (!$footer) {
                $footer = new FooterSetting();
            }

            $footer->fill($request->only([
                'brand_name',
                'brand_description',
                'email',
                'phone',
                'instagram',
                'address',
                'footer_note',
            ]));
            $footer->save();

            DB::commit();

            return redirect()->route('admin.settings.footer')
                ->with('success', 'Footer settings updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Footer setting update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update footer settings.');
        }
    }
}
