<?php
namespace App\Http\Controllers;

use App\Models\PenilaianMinat;
use App\Models\KriteriaMinat;
use App\Models\SubAlternatif;
use App\Models\Siswah;
use App\Http\Controllers\TopsisJenjangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TopsisMinatController extends Controller
{
    // Method to calculate the best alternative (peminatan)
    public function hasil()
    {
        $controller = new TopsisJenjangController();
        $alternatifTerbaik = $controller->getBestAlternatives(); // Ambil alternatif terbaik dari perhitungan TOPSIS jenjang
    
        $userId = Auth::id();
        $penilaians = PenilaianMinat::with([
            'pertanyaanminat.subalternatif',
            'pertanyaanminat.kriteriaminat'
        ])
        ->where('pengguna_id', $userId) // Filter berdasarkan user
        ->whereHas('pertanyaanminat.subalternatif', function ($query) use ($alternatifTerbaik) {
            $query->where('alternatif_id', $alternatifTerbaik['id']);
        })
        ->get();
    
        $kriteria = KriteriaMinat::all();
        $alternatifs = SubAlternatif::where('alternatif_id', $alternatifTerbaik['id'])->get();
        $weights = $kriteria->pluck('bobot', 'id')->toArray();
    
        $decisionMatrix = $this->buildDecisionMatrix($penilaians);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $weightedMatrix = $this->applyWeights($normalizedMatrix, $weights);
        $idealPositive = $this->calculateIdealPositive($weightedMatrix, $kriteria);
        $idealNegative = $this->calculateIdealNegative($weightedMatrix, $kriteria);
        list($positiveDistances, $negativeDistances) = $this->calculateDistance($weightedMatrix, $idealPositive, $idealNegative);
        $preferenceScores = $this->calculatePreferenceScores($positiveDistances, $negativeDistances);
    
        // Urutkan skor preferensi
        arsort($preferenceScores);
    
        // Ambil 3 alternatif terbaik
        $topAlternatives = [];
        foreach (array_slice($preferenceScores, 0, 3, true) as $subalternatifId => $score) {
            $alternative = $alternatifs->where('id', $subalternatifId)->first();
            $topAlternatives[] = [
                'nama' => $alternative ? $alternative->nama : 'Tidak ditemukan',
                'skor' => $score,
            ];
        }
    
        // Simpan alternatif terbaik di session (opsional)
        session(['alternatif_terbaik' => $topAlternatives]);

        $nomorIdentitas = Auth::user()->nomor_identitas; // Ambil nomor_identitas dari pengguna yang login
        $siswah = Siswah::where('nis', $nomorIdentitas)->first();
    
        if ($siswah) {
            // Ambil tiga peminatan terbaik
            $topPeminatan = array_slice($topAlternatives, 0, 3);
        
            // Ekstrak hanya nama peminatan
            $namaPeminatan = array_column($topPeminatan, 'nama');
        
            // Gabungkan nama dengan koma
            $namaPeminatanString = implode(', ', $namaPeminatan);
        
            // Simpan ke field rekomendasi_peminatan
            $siswah->rekomendasi_peminatan = $namaPeminatanString;
            $siswah->save();
        }
        
    
        // Definisikan $alternatifNames untuk digunakan di view
        $alternatifNames = $alternatifs->pluck('nama', 'id')->toArray();
    
        return view('penelusuran-minat.hasil', compact(
            'decisionMatrix', 'normalizedMatrix', 'weightedMatrix',
            'idealPositive', 'idealNegative', 'positiveDistances',
            'negativeDistances', 'preferenceScores', 'kriteria', 'topAlternatives', 'alternatifNames'
        ));
    }    

    // Method to build the decision matrix
    private function buildDecisionMatrix($penilaians)
{
    $decisionMatrix = [];

    foreach ($penilaians as $penilaian) {
        // Cek apakah data relasi untuk PenilaianMinat lengkap
        if ($penilaian->pertanyaanminat && 
            $penilaian->pertanyaanminat->subalternatif && 
            $penilaian->pertanyaanminat->kriteriaminat) {

            $subalternatifId = $penilaian->pertanyaanminat->subalternatif->id;
            $kriteriaminatId = $penilaian->pertanyaanminat->kriteriaminat->id;

            // Jika sudah ada nilai untuk subalternatif dan kriteria tertentu, tambahkan nilai
            if (!isset($decisionMatrix[$subalternatifId][$kriteriaminatId])) {
                $decisionMatrix[$subalternatifId][$kriteriaminatId] = [];
            }

            // Masukkan nilai pertanyaan untuk subalternatif dan kriteria
            $decisionMatrix[$subalternatifId][$kriteriaminatId][] = $penilaian->nilai;
        }
    }

    // Menghitung rata-rata nilai untuk setiap subalternatif dan kriteria
    foreach ($decisionMatrix as $subalternatifId => $kriteriaValues) {
        foreach ($kriteriaValues as $kriteriaminatId => $values) {
            // Hitung rata-rata untuk nilai-nilai yang ada
            $decisionMatrix[$subalternatifId][$kriteriaminatId] = array_sum($values) / count($values);
        }
    }

    return $decisionMatrix;
}

    // Method to normalize the decision matrix
    private function normalizeMatrix($decisionMatrix)
{
    $normalizedMatrix = [];
    
    foreach ($decisionMatrix as $subalternatifId => $kriteriaValues) {
        foreach ($kriteriaValues as $kriteriaminatId => $value) {
            // Menghitung sum of squares untuk setiap kriteria dengan cara mengumpulkan nilai pada kriteria tertentu di seluruh alternatif
            $sumSquare = array_sum(array_map(function($row) use ($kriteriaminatId) {
                return pow($row[$kriteriaminatId], 2);
            }, $decisionMatrix));
            
            // Normalisasi nilai
            $normalizedMatrix[$subalternatifId][$kriteriaminatId] = $value / sqrt($sumSquare);
        }
    }
    
    return $normalizedMatrix;
}


    // Method to apply weights to the normalized matrix
    private function applyWeights($normalizedMatrix, $weights)
{
    $weightedMatrix = [];

    foreach ($normalizedMatrix as $subalternatifId => $kriteriaValues) {
        foreach ($kriteriaValues as $kriteriaminatId => $value) {
            if (isset($weights[$kriteriaminatId])) {  // Pastikan bobot tersedia untuk kriteria terkait
                $weightedMatrix[$subalternatifId][$kriteriaminatId] = $value * $weights[$kriteriaminatId];
            }
        }
    }

    return $weightedMatrix;
}

    // Method to calculate the ideal positive solution
    // Method to calculate the ideal positive solution
private function calculateIdealPositive($weightedMatrix, $kriteria)
{
    $idealPositive = [];
    foreach ($kriteria as $kriteriaItem) {
        // Ambil semua nilai untuk kriteria tertentu
        $column = array_column($weightedMatrix, $kriteriaItem->id);
        
        // Tentukan solusi ideal positif berdasarkan atribut
        if ($kriteriaItem->atribut == 'benefit') {
            // Untuk kriteria 'benefit', solusi ideal positif adalah nilai maksimum
            $idealPositive[$kriteriaItem->id] = !empty($column) ? max($column) : 0;
        } else {
            // Untuk kriteria 'cost', solusi ideal positif adalah nilai minimum
            $idealPositive[$kriteriaItem->id] = !empty($column) ? min($column) : 0;
        }
    }
    return $idealPositive;
}

// Method to calculate the ideal negative solution
private function calculateIdealNegative($weightedMatrix, $kriteria)
{
    $idealNegative = [];
    foreach ($kriteria as $kriteriaItem) {
        // Ambil semua nilai untuk kriteria tertentu
        $column = array_column($weightedMatrix, $kriteriaItem->id);

        // Tentukan solusi ideal negatif berdasarkan atribut
        if ($kriteriaItem->atribut == 'benefit') {
            // Untuk kriteria 'benefit', solusi ideal negatif adalah nilai minimum
            $idealNegative[$kriteriaItem->id] = !empty($column) ? min($column) : 0;
        } else {
            // Untuk kriteria 'cost', solusi ideal negatif adalah nilai maksimum
            $idealNegative[$kriteriaItem->id] = !empty($column) ? max($column) : 0;
        }
    }
    return $idealNegative;
}


    // Method to calculate the distance between each alternative and the ideal solutions
    private function calculateDistance($weightedMatrix, $idealPositive, $idealNegative)
    {
        $positiveDistances = [];
        $negativeDistances = [];
        
        foreach ($weightedMatrix as $subalternatifId => $kriteriaValues) {
            $positiveDistance = 0;
            $negativeDistance = 0;

            foreach ($kriteriaValues as $kriteriaminatId => $value) {
                $positiveDistance += pow($value - $idealPositive[$kriteriaminatId], 2);
                $negativeDistance += pow($value - $idealNegative[$kriteriaminatId], 2);
            }

            $positiveDistances[$subalternatifId] = sqrt($positiveDistance);
            $negativeDistances[$subalternatifId] = sqrt($negativeDistance);
        }

        return [$positiveDistances, $negativeDistances];
    }

    // Method to calculate the preference score for each alternative
    // Method to calculate the preference score for each alternative
private function calculatePreferenceScores($positiveDistances, $negativeDistances)
{
    $preferenceScores = [];
    
    foreach ($positiveDistances as $subalternatifId => $positiveDistance) {
        $negativeDistance = $negativeDistances[$subalternatifId];
        
        // Cek apakah pembagi tidak nol
        if (($positiveDistance + $negativeDistance) != 0) {
            $preferenceScores[$subalternatifId] = $negativeDistance / ($positiveDistance + $negativeDistance);
        } else {
            // Jika pembagi nol, tetapkan skor preferensi sebagai nol (atau dapat diganti dengan nilai lain sesuai kebutuhan)
            $preferenceScores[$subalternatifId] = 0;
        }
    }

    return $preferenceScores;
}
public function getBestSubAlternatives()
{
    return session('alternatif_terbaik', []);
}
}

