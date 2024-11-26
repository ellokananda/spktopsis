<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;
    protected $fillable = ['nama'];

    public function subalternatifs(){
        return $this->hasMany(SubAlternatif::class);
    }

    public function penilaians(){
        return $this->hasMany(Penilaian::class);
    }

    public function penilaianminat(){
        return $this->hasMany(PenilaianMinat::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    // Model Alternatif
public function pertanyaan()
{
    return $this->hasMany(Pertanyaan::class, 'alternatif_id'); // Relasi Alternatif ke Pertanyaan
}

}
