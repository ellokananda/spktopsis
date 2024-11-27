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

    // Hitung poin total prestasi
    $prestasi = $request->input('prestasi', []); // Ambil data prestasi dari request
    $totalPrestasi = 1; // Inisialisasi total prestasi

    // Jika tidak ada prestasi, tambahkan poin default
    if (empty($prestasi)) {
        $prestasiTextString = 'Tidak ada prestasi';
    } else {
        // Hitung total nilai prestasi
        foreach ($prestasi as $item) {
            switch ($item) {
                case 'Juara 1 Kejuaraan Internasional':
                    $totalPrestasi += 60;
                    break;
                case 'Juara 1 Kejuaraan Nasional':
                    $totalPrestasi += 55;
                    break;
                case 'Juara 1 Kejuaraan Regional':
                    $totalPrestasi += 50;
                    break;
                case 'Juara 1 Kejuaraan Local':
                    $totalPrestasi += 45;
                    break;
                case 'Juara 2 Kejuaraan Internasional':
                    $totalPrestasi += 50;
                    break;
                case 'Juara 2 Kejuaraan Nasional':
                    $totalPrestasi += 45;
                    break;
                case 'Juara 2 Kejuaraan Regional':
                    $totalPrestasi += 40;
                    break;
                case 'Juara 2 Kejuaraan Local':
                    $totalPrestasi += 35;
                    break;
                case 'Juara 3 Kejuaraan Internasional':
                    $totalPrestasi += 30;
                    break;
                case 'Juara 3 Kejuaraan Nasional':
                    $totalPrestasi += 25;
                    break;
                case 'Juara 3 Kejuaraan Regional':
                    $totalPrestasi += 20;
                    break;
                case 'Juara 3 Kejuaraan Local':
                    $totalPrestasi += 15;
                    break;
            }
        }
        // Gabungkan prestasi menjadi string
        $prestasiTextString = implode(', ', $prestasi);
    }

    // Ambil nomor identitas pengguna yang login
    $nomor_identitas = Auth::user()->nomor_identitas;

    // Ambil data siswa berdasarkan nomor identitas
    $siswah = Siswah::where('nis', $nomor_identitas)->first();

    // Update data siswa dengan nilai rata-rata dan prestasi
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
            'pertanyaan_id' => $pertanyaan_id,
            'nilai' => $nilai,
            'rata' => $nilaiRataRata,
            'prestasi' => $totalPrestasi, // Simpan total nilai prestasi
        ]);
    }

    // Redirect dengan pesan sukses
    return redirect()->route('penelusuran-jenjang.index')->with('success', 'Penilaian berhasil disimpan');
}

}
