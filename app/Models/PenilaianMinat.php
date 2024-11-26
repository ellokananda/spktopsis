<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianMinat extends Model
{
    use HasFactory;
    protected $fillable = ['pengguna_id','pertanyaan_minat_id', 'nilai'];
 // Relasi ke PertanyaanMinat
 public function pertanyaanminat()
 {
     return $this->belongsTo(PertanyaanMinat::class, 'pertanyaan_minat_id');
 }

 // Relasi ke SubAlternatif melalui PertanyaanMinat
 public function subalternatif()
 {
     return $this->hasOneThrough(SubAlternatif::class, PertanyaanMinat::class, 'id', 'id', 'pertanyaan_minat_id', 'sub_alternatif_id');
 }

 // Relasi ke KriteriaMinat melalui PertanyaanMinat
 public function kriteriaminat()
 {
     return $this->pertanyaanminat->belongsTo(KriteriaMinat::class, 'kriteria_minat_id');
 }
 public function alternatif()
{
    return $this->belongsTo(Alternatif::class);
}
}
