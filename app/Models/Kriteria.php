<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi','atribut','bobot'];

    public function penilaian(){
        return $this->hasMany(Penilaian::class);
    }
    public function pilihans()
    {
        return $this->hasMany(Pilihan::class);
    }
    public function alternatif()
    {
        return $this->hasMany(Alternatif::class);
    }
    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class); // Sesuaikan dengan nama foreign key di tabel pertanyaans
    }
}
