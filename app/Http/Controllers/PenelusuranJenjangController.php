<?php

namespace App\Http\Controllers;
use App\Models\Pertanyaan;
use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\Siswah;
use App\Models\Alternatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenelusuranJenjangController extends Controller
{
    public function index()
{
    // Ambil semua pertanyaan, urutkan berdasarkan kriteria dan alternatif_id
    $pertanyaans = Pertanyaan::all()->sortBy(['kriteria_id', 'alternatif_id']);
    return view('penelusuran-jenjang.index', compact('pertanyaans'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'penilaian.*' => 'required|in:1,2,3,4,5',  // Skala Likert 1-5
        'rata' => 'required|numeric',              // Nilai rata-rata
        'prestasi' => 'array',                     // Prestasi sebagai array
    ]);

    // Ambil nilai rata-rata
    $nilaiRataRata = $request->input('rata');

    // Hitung poin rata-rata prestasi
    // Jika array prestasi kosong, buat prestasi default
    $prestasi = $request->input('prestasi', []);  // Ambil data prestasi dari request
    if (empty($prestasi)) {
        $prestasiTextString = 'Tidak ada prestasi';  // Jika tidak ada prestasi
    } else {
        // Gabungkan prestasi menjadi satu string dengan koma
        $prestasiTextString = implode(', ', $prestasi);  
    }
    
    $totalPrestasi = 0; // Total poin prestasi
    $prestasiText = []; 
    $jumlahPrestasi = count($prestasi);

    foreach ($prestasi as $item) {
        switch ($item) {
            case 'Juara 1 Kejuaraan Internasional (antar negara) ':
                $totalPrestasi += 60;
                break;
            case 'Juara 1 Kejuaraan Nasional (antar provinsi) ':
                $totalPrestasi += 55;
                break;
            case 'Juara 1 Kejuaraan Regional (antar kota atau kabupaten) ':
                $totalPrestasi += 50;
                break;
            case 'Juara 1 Kejuaraan Local (turnamen sekolah/kompetisi komunitas) ':
                $totalPrestasi += 45;
                break;
            case 'Juara 2 Kejuaraan Internasional (antar negara) ':
                $totalPrestasi += 50;
                break;
            case 'Juara 2 Kejuaraan Nasional (antar provinsi) ':
                $totalPrestasi += 45;
                break;
            case 'Juara 2 Kejuaraan Regional (antar kota atau kabupaten) ':
                $totalPrestasi += 40;
                break;
            case 'Juara 2 Kejuaraan Local (turnamen sekolah/kompetisi komunitas) ':
                $totalPrestasi += 35;
                break;
            case 'Juara 3 Kejuaraan Internasional (antar negara) ':
                $totalPrestasi += 30;
                break;
            case 'Juara 3 Kejuaraan Nasional (antar provinsi) ':
                $totalPrestasi += 25;
                break;
            case 'Juara 3 Kejuaraan Regional (antar kota atau kabupaten) ':
                $totalPrestasi += 20;
                break;
            case 'Juara 3 Kejuaraan Local (turnamen sekolah/kompetisi komunitas) ':
                $totalPrestasi += 15;
                break;
        }
    }

    $poinNonAkademik = $jumlahPrestasi > 0 ? $totalPrestasi / $jumlahPrestasi : 1;

    // Ambil nomor identitas pengguna yang login
    $nomor_identitas = Auth::user()->nomor_identitas;

    // Ambil data siswa berdasarkan nomor identitas
    $siswah = Siswah::where('nis', $nomor_identitas)->first();

    // Update field prestasi dengan string gabungan
    $siswah->update([
        'rata' => $nilaiRataRata,
        'prestasi' => $prestasiTextString,  // Simpan string prestasi
    ]);

    // Ambil ID pengguna saat ini
    $pengguna_id = Auth::id();

    // Simpan atau perbarui penilaian untuk setiap pertanyaan
    foreach ($request->penilaian as $pertanyaan_id => $nilai) {
        Penilaian::create([
            'pengguna_id' => $pengguna_id,
            'pertanyaan_id' => $pertanyaan_id,  // ID pertanyaan minat
            'nilai' => $nilai,                              // Nilai penilaian
            'rata' => $nilaiRataRata,
            'prestasi' => $poinNonAkademik,
        ]);
    }

    // Redirect dengan pesan sukses
    return redirect()->route('penelusuran-jenjang.index')->with('success', 'Penilaian berhasil disimpan');
}   
}
