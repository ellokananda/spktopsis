<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Pilihan;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::with('penilaians')->get();
        return view('penilaian.index', compact('alternatifs'));
    }

    public function create(Alternatif $alternatif)
    {
        // Ambil kriteria beserta pilihannya tanpa memanggil pertanyaan
        $kriterias = Kriteria::with('pilihans')->get();

        // Ambil penilaian lama dan simpan dalam array dengan kriteria_id sebagai kunci
        $penilaians = $alternatif->penilaians()->pluck('pilihan_id', 'kriteria_id')->toArray();

        return view('penilaian.create', compact('alternatif', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
{
    $request->validate([
        'alternatif_id' => 'required|exists:alternatifs,id',
        'penilaians.*' => 'required|exists:pilihans,id', // Validasi satu level array untuk pilihan
    ]);

    $alternatifId = $request->alternatif_id;
    $alternatif = Alternatif::find($alternatifId); // Ambil data alternatif
    $isSMA = $alternatif->nama == 'SMA'; // Asumsikan ada field 'nama' di Alternatif untuk cek SMA/SMK

    // Loop melalui setiap kriteria dan pilihan
    foreach ($request->penilaians as $kriteriaId => $pilihanId) {
        $pilihan = Pilihan::find($pilihanId);
        if ($pilihan) {
            $nilaiAkhir = $pilihan->nilai; // Nilai default dari pilihan

            // Cek jika kriteria adalah "peluang karir"
            $kriteria = Kriteria::find($kriteriaId);
            if ($kriteria && strtolower($kriteria->nama) == 'peluang karir') {
                if (strtolower($pilihan->nama) == 'kuliah') {
                    // Kuliah: 70% untuk SMA, 30% untuk SMK
                    $nilaiAkhir = $isSMA ? 0.6 * $pilihan->nilai : 0.4 * $pilihan->nilai;
                } elseif (strtolower($pilihan->nama) == 'kerja') {
                    // Kerja: 30% untuk SMA, 70% untuk SMK
                    $nilaiAkhir = $isSMA ? 0.4 * $pilihan->nilai : 0.6 * $pilihan->nilai;
                }
            }

            // Update atau buat penilaian untuk setiap kriteria dan pilihan
            Penilaian::updateOrCreate(
                [
                    'alternatif_id' => $alternatifId,
                    'kriteria_id' => $kriteriaId,
                ],
                [
                    'pilihan_id' => $pilihanId,
                    'nilai' => $nilaiAkhir, // Simpan nilai akhir yang sudah dihitung
                ]
            );
        }
    }

    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan.');
}

}