<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswah;

class HomeController extends Controller
{
    public function index()
{
    // Hitung total siswa
    $totalSiswa = Siswah::count();

    // Hitung jumlah siswa yang direkomendasikan ke SMA
    $siswaSMA = Siswah::where('rekomendasi_jenjang', 'SMA')->count();

    // Hitung jumlah siswa yang direkomendasikan ke SMK
    $siswaSMK = Siswah::where('rekomendasi_jenjang', 'SMK')->count();
    // dd(compact('totalSiswa', 'siswaSMA', 'siswaSMK'));
    // Kirim data ke view
    return view('index', compact('totalSiswa', 'siswaSMA', 'siswaSMK'));
}
}
