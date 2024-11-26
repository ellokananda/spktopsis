<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koordinator extends Model
{
    use HasFactory;
    protected $fillable = ['nip', 'nama', 'jeniskelamin', 'notelp', 'alamat']; // Field yang boleh diisi
}
