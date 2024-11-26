<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    use HasFactory;
    protected $fillable = [
        //'kriteria_id',
        'kriteria_id',
        'kriteria_minat_id',
        'nama',
        'nilai',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function kriteriaminat()
    {
        return $this->belongsTo(KriteriaMinat::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function penilaianminat(){
        return $this->hasMany(PenilaianMinat::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
