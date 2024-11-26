<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class AHPController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('ahp.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $data = $request->input('perbandingan');
        Log::info('Data perbandingan yang disimpan ke sesi: ', $data);
        
        // Simpan data ke sesi
        session(['perbandingan' => $data]);

        return redirect()->route('ahp.show')->with('success', 'Data berhasil disimpan!');
    }

    public function show()
    {
        $kriteria = Kriteria::all();
        $perbandingan = session('perbandingan', []);

        // Hitung matriks perbandingan lengkap
        $matrix = $this->calculateMatrix($kriteria, $perbandingan);

        // Hitung matriks normalisasi
        $normalizationResult = $this->normalizeMatrix($matrix);
        $normalizedMatrix = $normalizationResult['normalizedMatrix'];
        $rowSums = $normalizationResult['rowSums'];

        // Hitung bobot kriteria
        $weights = $this->calculateWeights($normalizedMatrix);

        // Simpan bobot ke database
        foreach ($kriteria as $index => $kri) {
            $bobot = $weights[$index+1] ?? 0; // Ambil nilai bobot
            Log::info('Menentukan bobot untuk kriteria ID ' . $kri->id . ': ' . $bobot); // Log nilai bobot
            $kri->update(['bobot' => $bobot]); // Perbarui bobot di database
        }

        // Hitung konsistensi
        $consistencyData = $this->checkConsistency($matrix, $weights);

        // Nilai RI
        $n = $consistencyData['jumlah_kriteria'];
        $RI = [0, 0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45]; // Nilai RI untuk n=1 sampai 10
        $riValue = $n > 0 && $n < 10 ? $RI[$n] : 'N/A';

        return view('ahp.show', compact('kriteria', 'matrix', 'normalizedMatrix', 'weights', 'rowSums', 'consistencyData', 'riValue'));
    }

    private function calculateMatrix($kriteria, $perbandingan)
    {
        $matrix = [];

        foreach ($kriteria as $k1) {
            foreach ($kriteria as $k2) {
                if ($k1->id === $k2->id) {
                    $matrix[$k1->id][$k2->id] = 1;
                } elseif (isset($perbandingan[$k1->id][$k2->id])) {
                    $nilai = $perbandingan[$k1->id][$k2->id]['nilai'];
                    $matrix[$k1->id][$k2->id] = $nilai;
                    $matrix[$k2->id][$k1->id] = 1 / $nilai;
                }
            }
        }

        return $matrix;
    }

    private function normalizeMatrix($matrix)
    {
        $columnSums = [];

        // Hitung jumlah kolom
        foreach ($matrix as $row) {
            foreach ($row as $col => $value) {
                if (!isset($columnSums[$col])) {
                    $columnSums[$col] = 0;
                }
                $columnSums[$col] += $value;
            }
        }

        $normalizedMatrix = [];
        $rowSums = []; // Array untuk menyimpan jumlah setiap baris
        foreach ($matrix as $i => $row) {
            $rowSum = 0; // Inisialisasi jumlah baris
            foreach ($row as $j => $value) {
                // Hindari pembagian dengan nol
                $normalizedValue = $columnSums[$j] != 0 ? $value / $columnSums[$j] : 0;
                $normalizedMatrix[$i][$j] = $normalizedValue;
                $rowSum += $normalizedValue; // Tambahkan nilai ke jumlah baris
            }
            $rowSums[$i] = $rowSum; // Simpan jumlah baris
        }

        return ['normalizedMatrix' => $normalizedMatrix, 'rowSums' => $rowSums];
    }

    private function calculateWeights($normalizedMatrix)
    {
        $weights = [];
        $numRows = count($normalizedMatrix);

        // Hitung rata-rata baris
        foreach ($normalizedMatrix as $i => $row) {
            $weights[$i] = $numRows > 0 ? array_sum($row) / $numRows : 0;
            Log::info('Bobot sementara untuk kriteria ID ' . $i . ': ' . $weights[$i]);
        }

        // Normalisasi bobot (agar bobot total menjadi 1)
        $totalWeight = array_sum($weights);
        if ($totalWeight > 0) {
            foreach ($weights as $i => $weight) {
                $weights[$i] = $weight / $totalWeight;
                Log::info('Bobot normalisasi untuk kriteria ID ' . $i . ': ' . $weights[$i]);
            }
        }

        return $weights;
    }

    private function checkConsistency($matrix, $weights)
    {
        $n = count($matrix);
        $weightedSumVector = [];

        // Menghitung vektor jumlah berbobot
        foreach ($matrix as $i => $row) {
            $weightedSumVector[$i] = 0;
            foreach ($row as $j => $value) {
                // Menghindari pembagian dengan nol
                if (isset($weights[$j]) && $weights[$j] != 0) {
                    $weightedSumVector[$i] += $value * $weights[$j];
                }
            }
        }

        // Menghitung Lambda Maksimum (λ_max)
        $lambdaMax = 0;
        foreach ($weightedSumVector as $i => $value) {
            // Menghindari pembagian dengan nol
            if (isset($weights[$i]) && $weights[$i] != 0) {
                $lambdaMax += $value / $weights[$i];
            }
        }
        $lambdaMax = $n > 1 ? $lambdaMax / $n : 0; // Menghindari pembagian dengan nol jika n <= 1

        // Menghitung Indeks Konsistensi (CI)
        $CI = ($lambdaMax - $n) / ($n - 1);

        // Menghitung Konsistensi Rasio (CR)
        $RI = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45]; // Nilai RI untuk n=1 sampai 10
        $CR = $n > 1 && isset($RI[$n]) ? $CI / $RI[$n] : 0; // Menghindari pembagian dengan nol jika RI tidak ada

        return [
            'lambda_max' => $lambdaMax,
            'CI' => $CI,
            'CR' => $CR,
            'jumlah_kriteria' => $n
        ];
    }
}