<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{ // LOGIN FIREBASE
    public function loginFirebase(Request $request)
    {
        // VALIDASI
        $request->validate([
            'firebase_uid' => 'required|string'
        ]);

        // CARI USER BERDASARKAN FIREBASE UID
        $user = User::where(
            'firebase_uid',
            $request->firebase_uid
        )->first();

        // CEK USER
        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // RESPONSE
        return response()->json([
            'message' => 'Login berhasil',
            'data' => $user
        ], 200);
    }
    // REGISTER
    public function register(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'firebase_uid' => 'required|string',
            'nik' => 'required|string|unique:users,nik',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'required|string|max:15',
        ]);

        // SIMPAN USER
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'firebase_uid' => $validated['firebase_uid'],
            'nik' => $validated['nik'],
            'alamat' => $validated['alamat'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'nomor_telepon' => $validated['nomor_telepon'],
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'data' => $user
        ], 201);
    }
}
