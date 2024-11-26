<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $fillable = ['kriteria_id','alternatif_id', 'pertanyaan'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
    
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
    public function siswah()
    {
        return $this->hasMany(Siswah::class);
    }
   
}
