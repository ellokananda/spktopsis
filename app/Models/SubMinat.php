<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMinat extends Model
{
    use HasFactory;

    protected $fillable = ['minat_id', 'nama'];

    public function minat()
    {
        return $this->belongsTo(Minat::class);
    }

    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}
