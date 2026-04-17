<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UsulanController extends Controller
{
    /**
     * Simpan usulan baru dari Flutter
     */
    public function store(Request $request)
    {
        // 🔥 Mapping biar fleksibel dari Flutter
        $request->merge([
            'lokasi_detail' => $request->lokasi_detail ?? $request->lokasi,
        ]);

        // 1. VALIDASI (lebih aman & fleksibel)
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'dusun'                => 'required',
            'judul_usulan' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'urgensi'              => 'required',
            'masyarakat_terdampak' => 'required',
            'tingkat_kerusakan'    => 'required',
            'biaya' => 'required|numeric',
            'lokasi_detail'        => 'required',
            'koordinat'            => 'nullable',
            'foto_usulan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'input'  => $request->all(),
                'files'  => $request->allFiles(),
            ], 422);
        }

        // 🔥 Pastikan biaya numeric (kadang dari Flutter string)
        $biaya = preg_replace('/[^0-9]/', '', $request->biaya);

        // 2. Upload Foto
        $namaFoto = null;
        if ($request->hasFile('foto_usulan')) {
            $file = $request->file('foto_usulan');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/usulans', $namaFoto);
        }

        // 3. Simpan ke database
        $usulan = Usulan::create([
            'user_id'              => $request->user_id,
            'dusun'                => $request->dusun,
            'judul_usulan'         => $request->judul_usulan ?? 'Tanpa Judul',
            'permasalahan'         => $request->permasalahan ?? '-',
            'urgensi'              => $request->urgensi,
            'masyarakat_terdampak' => $request->masyarakat_terdampak,
            'tingkat_kerusakan'    => $request->tingkat_kerusakan,
            'biaya'                => $biaya,
            'lokasi_detail'        => $request->lokasi_detail,
            'koordinat'            => $request->koordinat,
            'foto_usulan'          => $namaFoto,
            'status'               => 'pending',

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usulan berhasil dikirim ke Admin!',
            'data'    => $usulan

        ], 201);
    }

    /**
     * Ambil data usulan milik User tertentu (untuk daftar status)
     */
    public function index($user_id)
    {
        $data = Usulan::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ], 200);
    }
}
