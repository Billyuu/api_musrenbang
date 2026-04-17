<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'dusun',
        'judul_usulan',
        'permasalahan',
        'urgensi',
        'masyarakat_terdampak',
        'tingkat_kerusakan',
        'biaya',
        'lokasi_detail',
        'koordinat',
        'foto_usulan',
        'status',
    ];

    // Relasi: Usulan ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}