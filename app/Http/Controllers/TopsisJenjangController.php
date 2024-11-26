<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Siswah;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TopsisJenjangController extends Controller
{
    public function hasil()
{
    
    // Ambil semua data yang diperlukan
    $userId = Auth::id();
        $penilaians = Penilaian::with([
            'pertanyaan.alternatif',
            'pertanyaan.kriteria'
        ])
        ->where('pengguna_id', $userId) // Filter berdasarkan user
        ->get();
    $kriteria = Kriteria::all();
    $alternatifs = Alternatif::all();
    
    // Ambil bobot dari tabel kriteria dan masukkan ke array
    $weights = $kriteria->pluck('bobot', 'id')->toArray();

    // $nilaiRata = $penilaians->where('kriteria_id', 'akademik')->avg('nilai'); // Gantilah dengan perhitungan yang sesuai
    // $nilaiPrestasi = $penilaians->where('kriteria_id', 'non_akademik')->avg('nilai'); // Gantilah dengan perhitungan yang sesuai
    // Langkah-langkah perhitungan TOPSIS
    $decisionMatrix = $this->buildDecisionMatrix($penilaians);
    $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
    $weightedMatrix = $this->applyWeights($normalizedMatrix, $weights);
    $idealPositive = $this->calculateIdealPositive($weightedMatrix, $kriteria);
    $idealNegative = $this->calculateIdealNegative($weightedMatrix, $kriteria);
    list($positiveDistances, $negativeDistances) = $this->calculateDistance($weightedMatrix, $idealPositive, $idealNegative);
    $preferenceScores = $this->calculatePreferenceScores($positiveDistances, $negativeDistances);

    // Urutkan Skor Preferensi
    arsort($preferenceScores);

    // Ambil ID alternatif terbaik
    $bestAlternativeId = array_key_first($preferenceScores); // Ambil ID alternatif dengan skor tertinggi
    $bestAlternativeName = $alternatifs->where('id', $bestAlternativeId)->first()->nama; // Nama alternatif terbaik

    // Simpan alternatif terbaik dalam session
    session(['jenjang_terbaik' => [
        'id' => $bestAlternativeId,
        'nama' => $bestAlternativeName,
        'skor' => $preferenceScores[$bestAlternativeId]
    ]]);

    $nomorIdentitas = Auth::user()->nomor_identitas; // Ambil nomor_identitas dari pengguna yang login
    $siswah = Siswah::where('nis', $nomorIdentitas)->first();

    if ($siswah) {
        $siswah->rekomendasi_jenjang = $bestAlternativeName;
        $siswah->save();
    }

    // Definisikan $alternatifNames untuk digunakan di view
    $alternatifNames = $alternatifs->pluck('nama', 'id')->toArray();

    // Kirim semua variabel ke view, termasuk $kriteria
    return view('penelusuran-jenjang.hasil', compact(
        'decisionMatrix', 'normalizedMatrix', 'weightedMatrix',
        'idealPositive', 'idealNegative', 'positiveDistances',
        'negativeDistances', 'preferenceScores', 'alternatifNames', 'kriteria'
    ));
}


// Fungsi untuk membangun matriks keputusan
// Fungsi untuk membangun matriks keputusan
private function buildDecisionMatrix($penilaians)
{
    $decisionMatrix = [];

    foreach ($penilaians as $penilaian) {
        $alternatifId = $penilaian->pertanyaan->alternatif->id;
        $kriteriaId = $penilaian->pertanyaan->kriteria->id;
        $nilai = $penilaian->nilai;
        $nilaiRata = $penilaian->rata;
        $nilaiPrestasi = $penilaian->prestasi;

        if ($kriteriaId == 1) {
            $nilai = ($nilai + $nilaiRata) / 2;
        } elseif ($kriteriaId == 2) {
            $nilai = ($nilai + $nilaiPrestasi) / 2;
        }

        // Jika sudah ada nilai sebelumnya pada kriteria ini untuk alternatif ini,
        // tambahkan nilai ke array, jika belum, buat array baru
        if (!isset($decisionMatrix[$alternatifId][$kriteriaId])) {
            $decisionMatrix[$alternatifId][$kriteriaId] = [];
        }

        // Simpan nilai-nilai yang ditemukan ke dalam array
        $decisionMatrix[$alternatifId][$kriteriaId][] = $nilai;
    }

    // Hitung rata-rata untuk setiap kriteria di setiap alternatif
    foreach ($decisionMatrix as $alternatifId => $kriteriaValues) {
        foreach ($kriteriaValues as $kriteriaId => $nilaiArray) {
            // Jika terdapat lebih dari satu nilai, hitung rata-ratanya
            $decisionMatrix[$alternatifId][$kriteriaId] = array_sum($nilaiArray) / count($nilaiArray);
        }
    }

    return $decisionMatrix;
}

    // Fungsi normalisasi matriks
    private function normalizeMatrix($decisionMatrix)
    {
        $normalizedMatrix = [];
        
        foreach ($decisionMatrix as $alternatifId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                $sumSquare = array_sum(array_map(fn($x) => pow($x, 2), array_column($decisionMatrix, $kriteriaId)));
                $normalizedMatrix[$alternatifId][$kriteriaId] = $nilai / sqrt($sumSquare);
            }
        }

        return $normalizedMatrix;
    }

    // Fungsi untuk menerapkan bobot
    private function applyWeights($normalizedMatrix, $weights)
    {
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $alternatifId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                if (isset($weights[$kriteriaId])) {  // Sesuaikan kriteriaId dengan bobot dari database
                    $weightedMatrix[$alternatifId][$kriteriaId] = $nilai * $weights[$kriteriaId];
                }
            }
        }

        return $weightedMatrix;
    }

    // Fungsi untuk menghitung solusi ideal positif (dengan atribut cost/benefit)
    private function calculateIdealPositive($weightedMatrix, $kriteria)
{
    $idealPositive = [];

    foreach ($kriteria as $k) {
        if ($k->atribut === 'benefit') {
            // Ideal positif untuk benefit adalah nilai maksimum
            $idealPositive[$k->id] = max(array_column($weightedMatrix, $k->id));
        } elseif ($k->atribut === 'cost') {
            // Ideal positif untuk cost adalah nilai minimum
            $idealPositive[$k->id] = min(array_column($weightedMatrix, $k->id));
        }
    }

    return $idealPositive;
}


    // Fungsi untuk menghitung solusi ideal negatif (dengan atribut cost/benefit)
    private function calculateIdealNegative($weightedMatrix, $kriteria)
{
    $idealNegative = [];

    foreach ($kriteria as $k) {
        if ($k->atribut === 'benefit') {
            // Ideal negatif untuk benefit adalah nilai minimum
            $idealNegative[$k->id] = min(array_column($weightedMatrix, $k->id));
        } elseif ($k->atribut === 'cost') {
            // Ideal negatif untuk cost adalah nilai maksimum
            $idealNegative[$k->id] = max(array_column($weightedMatrix, $k->id));
        }
    }

    return $idealNegative;
}


    // Fungsi untuk menghitung jarak ke solusi ideal
    private function calculateDistance($weightedMatrix, $idealPositive, $idealNegative)
{
    $positiveDistances = [];
    $negativeDistances = [];

    foreach ($weightedMatrix as $alternatifId => $kriteriaValues) {
        $positiveDistance = 0;
        $negativeDistance = 0;

        foreach ($kriteriaValues as $kriteriaId => $nilai) {
            // Menghitung jarak Euclidean ke solusi ideal positif
            $positiveDistance += pow($nilai - $idealPositive[$kriteriaId], 2);
            // Menghitung jarak Euclidean ke solusi ideal negatif
            $negativeDistance += pow($nilai - $idealNegative[$kriteriaId], 2);
        }

        $positiveDistances[$alternatifId] = sqrt($positiveDistance);
        $negativeDistances[$alternatifId] = sqrt($negativeDistance);
    }

    return [$positiveDistances, $negativeDistances];
}

    // Fungsi untuk menghitung skor preferensi
    private function calculatePreferenceScores($positiveDistances, $negativeDistances)
{
    $preferenceScores = [];

    foreach ($positiveDistances as $alternatifId => $positiveDistance) {
        $negativeDistance = $negativeDistances[$alternatifId];
        // Menghitung skor preferensi dengan rumus TOPSIS
        $preferenceScores[$alternatifId] = $negativeDistance / ($positiveDistance + $negativeDistance);
    }

    return $preferenceScores;
}

    public function getBestAlternatives()
    {
        return session('jenjang_terbaik', []);
    }

}
