<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Endpoint: GET /api/menus
    public function index()
    {
        $menus = Menu::all(); // Atau pakai pagination jika perlu
        return response()->json([
            'message' => 'Menu list fetched successfully',
            'data' => $menus
        ]);
    }

    // Endpoint: GET /api/menus/{id}
    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return response()->json([
            'message' => 'Menu detail fetched successfully',
            'data' => $menu
        ]);
    }
}
