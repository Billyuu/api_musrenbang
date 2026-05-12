<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // UPDATE ALAMAT
    public function updateAlamat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'alamat' => 'required|string'
        ]);

        $user = User::find($request->user_id);

        $user->alamat = $request->alamat;
        $user->save();

        return response()->json([
            'message' => 'Alamat berhasil diupdate',
            'data' => $user
        ]);
    }
    // UPDATE NO HP
    public function updateNoHp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_telepon' => 'required|string|max:15'
        ]);

        $user = User::find($request->user_id);

        $user->nomor_telepon = $request->nomor_telepon;
        $user->save();

        return response()->json([
            'message' => 'No HP berhasil diupdate',
            'data' => $user
        ]);
    }
    //get profile
    public function getProfile(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'nik' => $user->nik,
                'alamat' => $user->alamat,
                'nomor_telepon' => $user->nomor_telepon,
                'jenis_kelamin' => $user->jenis_kelamin,
                'foto_url' => $user->foto
                    ? asset('storage/' . $user->foto)
                    : null,
            ]
        ]);
    }

    // UPDATE FOTO PROFILE
    public function updateFoto(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // VALIDASI
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            // 🔥 HAPUS FOTO LAMA
            if (
                $user->foto &&
                Storage::disk('public')->exists($user->foto)
            ) {
                Storage::disk('public')->delete($user->foto);
            }

            // 🔥 SIMPAN FOTO BARU
            $file = $request->file('foto');

            $path = $file->store('profile', 'public');

            // 🔥 UPDATE DATABASE
            $user->foto = $path;
            $user->save();

            return response()->json([
                'message' => 'Foto profile berhasil diupdate',
                'user_id' => $user->id,
                'foto_database' => $user->foto,
                'data' => [
                    'foto_url' => asset('storage/' . $path)
                ]
            ]);
        }

        return response()->json([
            'message' => 'File tidak ditemukan'
        ], 400);
    }
}
