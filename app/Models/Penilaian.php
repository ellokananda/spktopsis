<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $fillable = ['pengguna_id','pertanyaan_id', 'nilai', 'rata', 'prestasi'];

    public function alternatif(){
        return $this->belongsTo(Alternatif::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function pilihan(){
        return $this->belongsTo(Pilihan::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
    public function pengguna()
{
    return $this->belongsTo(Pengguna::class, 'pengguna_id', 'id');
}

}
