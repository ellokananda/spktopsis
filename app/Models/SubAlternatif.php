<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAlternatif extends Model
{
    use HasFactory;
    protected $fillable = [
        'alternatif_id',
        'nama',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }
    public function penilaianminat(){
        return $this->hasMany(PenilaianMinat::class);
    }
    public function kriteriaminat()
    {
        return $this->belongsTo(KriteriaMinat::class);
    }
        public function pertanyaanminat()
    {
        return $this->hasMany(PertanyaanMinat::class);
    }

}
