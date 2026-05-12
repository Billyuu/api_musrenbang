<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'firebase_uid',
        'nik',
        'alamat',
        'jenis_kelamin',
        'nomor_telepon',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];
}
