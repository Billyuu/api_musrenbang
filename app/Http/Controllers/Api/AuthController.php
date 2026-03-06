<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1️⃣ Validasi
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        // 2️⃣ Cari user berdasarkan NIK
        $user = \App\Models\User::where('nik', $request->nik)->first();

        // 3️⃣ Cek apakah user ada
        if (!$user) {
            return response()->json([
                'message' => 'NIK tidak ditemukan'
            ], 404);
        }

        // 4️⃣ Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password salah'
            ], 401);
        }

        // 5️⃣ Login berhasil
        return response()->json([
            'message' => 'Login berhasil',
            'data' => $user
        ], 200);
    }

    public function register(Request $request)
    {
        // 1️⃣ Validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'required|string|max:15',
            'password' => 'required|string|min:6'
        ]);

        // 2️⃣ Simpan user
        $user = User::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'alamat' => $validated['alamat'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password'])
        ]);

        // 3️⃣ Response
        return response()->json([
            'message' => 'Register berhasil',
            'data' => $user
        ], 201);
    }
}
