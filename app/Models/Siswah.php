<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'tahun_akademik',
        'nama',
        'jenis_kelamin',
        'rata',
        'prestasi',
        'rekomendasi_jenjang',
        'rekomendasi_peminatan',
    ];

    public function tahun() {
        return $this->belongsTo(Tahun::class);
    }
    public function pertanyaan()
{
    return $this->belongsTo(Pertanyaan::class);
}

}
