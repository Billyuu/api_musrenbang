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
    //uploud foto
    public function getProfile()
    {
        $user = User::first(); // sementara

        

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'data' => [
                'nama' => $user->name,
                'foto_url' => $user->foto
                    ? asset('storage/' . $user->foto)
                    : null,
            ]
            

        ]);
        
    }

    // 🔥 UPDATE FOTO PROFILE
    public function updateFoto(Request $request)
    {
        $user = User::first(); // sementara, nanti pakai auth

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        if (!$request->hasFile('foto')) {
            return response()->json(['message' => 'Tidak ada file yang diupload'], 400);
        }

        $file = $request->file('foto');
        $path = $file->store('profile', 'public');

        $user->foto = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profile berhasil diupdate',
            'data' => [
                'foto_url' => asset('storage/' . $path)
            ]
        ]);
    }
}
