<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanMinat extends Model
{
    use HasFactory;
    protected $fillable = ['kriteria_minat_id','sub_alternatif_id', 'pertanyaan'];

    public function kriteriaminat()
    {
        return $this->belongsTo(KriteriaMinat::class, 'kriteria_minat_id');
    }

    public function subalternatif()
    {
        return $this->belongsTo(SubAlternatif::class, 'sub_alternatif_id');
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }
    
    public function penilaianminat()
    {
        return $this->hasMany(PenilaianMinat::class);
    }
}
