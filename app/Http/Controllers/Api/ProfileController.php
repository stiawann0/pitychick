<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $profiles = UserProfile::where('user_id', Auth::id())
                                  ->orderBy('is_default', 'desc')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

            return response()->json([
                'success' => true,
                'profiles' => $profiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data alamat'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'profile_name' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'address' => 'required|string',
                'phone' => 'required|string',
                'is_default' => 'boolean'
            ]);

            if ($request->is_default) {
                UserProfile::where('user_id', Auth::id())
                          ->update(['is_default' => false]);
            }

            $profile = UserProfile::create([
                'user_id' => Auth::id(),
                'profile_name' => $request->profile_name,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'is_default' => $request->is_default ?? false
            ]);

            return response()->json([
                'success' => true,
                'profile' => $profile,
                'message' => 'Alamat berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan alamat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profile = UserProfile::where('user_id', Auth::id())
                                 ->where('id', $id)
                                 ->firstOrFail();

            $request->validate([
                'profile_name' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'address' => 'required|string',
                'phone' => 'required|string',
                'is_default' => 'boolean'
            ]);

            if ($request->is_default) {
                UserProfile::where('user_id', Auth::id())
                          ->update(['is_default' => false]);
            }

            $profile->update($request->all());

            return response()->json([
                'success' => true,
                'profile' => $profile,
                'message' => 'Alamat berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate alamat'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $profile = UserProfile::where('user_id', Auth::id())
                                 ->where('id', $id)
                                 ->firstOrFail();

            $profile->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus alamat'
            ], 500);
        }
    }

    public function setDefault($id)
    {
        try {
            $profile = UserProfile::where('user_id', Auth::id())
                                 ->where('id', $id)
                                 ->firstOrFail();

            $profile->setAsDefault();

            return response()->json([
                'success' => true,
                'profile' => $profile,
                'message' => 'Alamat default berhasil diubah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengatur alamat default'
            ], 500);
        }
    }
}