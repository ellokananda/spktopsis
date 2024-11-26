<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_akademik'];

    public function siswas() {
        return $this->hasMany(Siswah::class);
    }
}