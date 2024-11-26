<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    // Tentukan kolom yang dapat diisi (fillable) sesuai dengan field yang Anda miliki
    protected $fillable = [
        'nomor_identitas',
        'nama',
        'username',
        'password',
        'role',
    ];

    // Pastikan Anda melindungi kolom password agar aman dari pengisian massal
    protected $hidden = [
        'password',
    ];

    public function penilaians()
{
    return $this->hasMany(Penilaian::class, 'pengguna_id', 'id');
}

}
