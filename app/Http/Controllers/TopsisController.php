<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubAlternatif;
use App\Models\Pilihan;
use Illuminate\Support\Facades\Log;


class TopsisController extends Controller
{
    public function calculate()
    {
        $kriteria = Kriteria::all(); // Ambil semua kriteria dari database
        $alternatifs = Alternatif::all();
        $penilaians = Penilaian::all();

        // Ambil bobot kriteria dari database
        $weights = $kriteria->pluck('bobot', 'id')->toArray();

        // Persiapkan matriks keputusan dari penilaian
        $decisionMatrix = $this->prepareDecisionMatrix($penilaians, $kriteria);

        // Hitung matriks normalisasi
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

        // Hitung matriks terbobot
        $weightedMatrix = $this->applyWeights($normalizedMatrix, $weights);

        // Tentukan solusi ideal positif dan negatif
        $idealPositive = $this->calculateIdealPositive($weightedMatrix, $kriteria);
        $idealNegative = $this->calculateIdealNegative($weightedMatrix, $kriteria);

        // Hitung jarak dari solusi ideal positif dan negatif
        $preferenceScores = $this->calculatePreferenceScores($weightedMatrix, $idealPositive, $idealNegative);

        // Cari alternatif dengan skor preferensi tertinggi dan simpan dalam session
        $bestAlternative = $this->findBestAlternative($preferenceScores, $alternatifs);

        // Kirim data ke view
        return view('topsis.result', compact('kriteria', 'decisionMatrix', 'normalizedMatrix', 'weightedMatrix', 'idealPositive', 'idealNegative', 'preferenceScores', 'alternatifs', 'bestAlternative'));
    }

    // Fungsi baru untuk menemukan alternatif terbaik
    private function findBestAlternative($preferenceScores, $alternatifs)
    {
        // Cari skor tertinggi
        $maxScore = max(array_column($preferenceScores, 'score'));

        // Temukan semua alternatif yang memiliki skor tertinggi
        $bestAlternatives = array_filter($preferenceScores, function($score) use ($maxScore) {
            return $score['score'] == $maxScore;
        });

        // Ambil semua ID dari alternatif dengan skor tertinggi
        $bestAlternativeIds = array_keys($bestAlternatives);

        // Cari semua alternatif dengan ID tersebut
        $bestAlternativesData = $alternatifs->whereIn('id', $bestAlternativeIds);

        // Simpan alternatif terbaik dalam session
        session(['best_alternatives' => $bestAlternativesData->toArray()]);
        
        // Log untuk memastikan bahwa alternatif terbaik tersimpan
        //Log::info('Best Alternatives: ', $bestAlternativesData->toArray());

        return $bestAlternativesData;
    }

    public function showBestAlternativesSubalternatifs()
    {
        // Ambil alternatif terbaik dari session
        $bestAlternatives = session('best_alternatives', []);

        // Cek apakah ada alternatif terbaik yang disimpan di session
        if (!empty($bestAlternatives)) {
            // Cari subalternatif yang terkait dengan alternatif terbaik
            $subAlternatifs = SubAlternatif::whereIn('alternatif_id', array_column($bestAlternatives, 'id'))->get();
        } else {
            $subAlternatifs = collect(); // Kumpulan kosong jika tidak ada alternatif terbaik
        }

        // Log untuk memastikan data subalternatif ada
        Log::info('Subalternatifs retrieved: ', $subAlternatifs->toArray());

        // Kirim subalternatif ke view
        return view('penilaianminat.index', compact('subAlternatifs'));
    }

    private function prepareDecisionMatrix($penilaians, $kriteria)
    {
        $matrix = [];
    
        foreach ($penilaians as $penilaian) {
            $alternatifId = $penilaian->alternatif_id;
            $kriteriaId = $penilaian->kriteria_id;
            $nilai = $penilaian->nilai;
    
            // Inisialisasi matrix untuk alternatif jika belum ada
            if (!isset($matrix[$alternatifId])) {
                $matrix[$alternatifId] = [];
            }
    
            // Cek jika kriteria adalah peluang karir
            if ($kriteriaId === 3) { // Ganti dengan ID kriteria yang sesuai
                // Menentukan apakah alternatif adalah SMA atau SMK
                $alternatif = Alternatif::find($alternatifId);
                $isSMA = strpos(strtolower($alternatif->nama), 'sma') !== false; // Cek apakah nama mengandung 'sma'
                $pilihan = Pilihan::find($penilaian->pilihan_id);
    
                // Log untuk memeriksa pilihan dan nilainya
                if ($pilihan) {
                    Log::info('Pilihan ID: ' . $pilihan->id . ', Nama Pilihan: ' . $pilihan->nama . ', Nilai: ' . $pilihan->nilai);
                    
                    if (strtolower($pilihan->nama) === 'kuliah') {
                        $nilai = $isSMA ? 0.6 * $pilihan->nilai : 0.4 * $pilihan->nilai;
                    } elseif (strtolower($pilihan->nama) === 'kerja') {
                        $nilai = $isSMA ? 0.4 * $pilihan->nilai : 0.6 * $pilihan->nilai;
                    }
                }
    
                // Log nilai yang dihitung
                Log::info('Nilai yang digunakan untuk alternatif ID: ' . $alternatifId . ' pada kriteria peluang karir: ' . $nilai);
            }
    
            // Masukkan nilai ke dalam matriks keputusan
            $matrix[$alternatifId][$kriteriaId] = $nilai;
        }
    
        return $matrix;
    }
    

    private function normalizeMatrix($matrix)
    {
        $columnSums = [];
        $normalizedMatrix = [];

        // Hitung jumlah kuadrat kolom
        foreach ($matrix as $row) {
            foreach ($row as $col => $value) {
                if (!isset($columnSums[$col])) {
                    $columnSums[$col] = 0;
                }
                $columnSums[$col] += pow($value, 2);
            }
        }

        // Ambil akar kuadrat dari jumlah kuadrat kolom
        foreach ($columnSums as &$sum) {
            $sum = sqrt($sum);
        }

        // Normalisasi matriks
        foreach ($matrix as $altId => $row) {
            foreach ($row as $col => $value) {
                $normalizedMatrix[$altId][$col] = $value / ($columnSums[$col] != 0 ? $columnSums[$col] : 1);
            }
        }

        return $normalizedMatrix;
    }

    private function applyWeights($normalizedMatrix, $weights)
    {
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $altId => $values) {
            foreach ($values as $kriteriaId => $value) {
                $weightedMatrix[$altId][$kriteriaId] = $value * ($weights[$kriteriaId] ?? 1);
            }
        }

        return $weightedMatrix;
    }

    private function calculateIdealPositive($weightedMatrix, $kriteria)
    {
        $idealPositive = [];

        foreach ($kriteria as $k) {
            $attribute = $k->atribut;
            $values = array_column($weightedMatrix, $k->id);
            
            if ($attribute == 'benefit') {
                $idealPositive[$k->id] = max($values);
            } else { // cost
                $idealPositive[$k->id] = min($values);
            }
        }

        return $idealPositive;
    }

    private function calculateIdealNegative($weightedMatrix, $kriteria)
    {
        $idealNegative = [];

        foreach ($kriteria as $k) {
            $attribute = $k->atribut;
            $values = array_column($weightedMatrix, $k->id);
            
            if ($attribute == 'benefit') {
                $idealNegative[$k->id] = min($values);
            } else { // cost
                $idealNegative[$k->id] = max($values);
            }
        }

        return $idealNegative;
    }

    private function calculatePreferenceScores($weightedMatrix, $idealPositive, $idealNegative)
    {
        $preferenceScores = [];

        foreach ($weightedMatrix as $altId => $values) {
            $dPos = 0;
            $dNeg = 0;

            foreach ($values as $kriteriaId => $value) {
                $dPos += pow($value - $idealPositive[$kriteriaId], 2);
                $dNeg += pow($value - $idealNegative[$kriteriaId], 2);
            }

            $dPos = sqrt($dPos);
            $dNeg = sqrt($dNeg);

            $preferenceScores[$altId] = [
                'dPos' => $dPos,
                'dNeg' => $dNeg,
                'score' => ($dPos + $dNeg) != 0 ? $dNeg / ($dPos + $dNeg) : 0
            ];
        }

        return $preferenceScores;
    }
    
    public function showBestAlternatives()
    {
        // Ambil alternatif terbaik dari session
        $bestAlternatives = session('best_alternatives', []);
    
        // Log untuk memastikan alternatif terbaik ada
        // Log::info('Best Alternatives from session: ', $bestAlternatives);
    
        // Kirim data ke view
        return view('topsisminat.best_alternatives', compact('bestAlternatives'));
    }

    public function getBestAlternatives()
{
    return session('best_alternatives', []);
}
    
}