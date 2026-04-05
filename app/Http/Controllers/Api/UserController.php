<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // 🔥 UPDATE ALAMAT
    public function updateAlamat(Request $request)
    {
        $user = User::first(); // sementara

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->alamat = $request->alamat;
        $user->save();

        return response()->json([
            'message' => 'Alamat berhasil diupdate',
            'data' => $user
        ]);
    }

    // 🔥 UPDATE NO HP
    public function updateNoHp(Request $request)
    {
        $user = User::first(); // sementara

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->nomor_telepon = $request->nomor_telepon;
        $user->save();

        return response()->json([
            'message' => 'No HP berhasil diupdate',
            'data' => $user
        ]);
    }
}