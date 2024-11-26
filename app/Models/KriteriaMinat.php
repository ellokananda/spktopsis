<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaMinat extends Model
{
    use HasFactory;
    protected $fillable = ['nama','deskripsi', 'atribut','bobot'];

    
    public function pilihans()
    {
        return $this->hasMany(Pilihan::class);
    }

    public function subalternatif()
    {
        return $this->hasMany(SubAlternatif::class);
    }

    public function penilaianminat(){
        return $this->hasMany(PenilaianMinat::class);
    }
    public function pertanyaanminat(){
        return $this->hasMany(PertanyaanMinat::class);
    }
}
