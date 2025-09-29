<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavigationSetting;
use Illuminate\Http\Request;

class NavigationSettingsController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->check() ? auth()->user()->role : 'all';

        $items = NavigationSetting::where('is_active', 1)
            ->where(function ($q) use ($role) {
                $q->where('role', $role)
                  ->orWhere('role', 'all');
            })
            ->orderBy('position')
            ->get();

        return response()->json($items);
    }
}