<?php

namespace App\Http\Controllers;

use App\Models\PenilaianMinat;
use App\Models\SubAlternatif;
use App\Models\KriteriaMinat;
use App\Models\Pilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenilaianMinatController extends Controller
{
    // Method to display the index view with sub-alternatives
    public function index()
    {
        // Retrieve best alternatives from the session
        $bestAlternatives = session('best_alternatives', []);

        if (!empty($bestAlternatives)) {
            // Get sub-alternatives associated with the best alternatives
            $subAlternatifs = SubAlternatif::whereIn('alternatif_id', array_column($bestAlternatives, 'id'))->get();
        } else {
            $subAlternatifs = collect(); // Empty collection if no best alternatives
        }

        // Log the retrieved sub-alternatives
        Log::info('Retrieved SubAlternatifs: ', $subAlternatifs->toArray());

        // Return the view with sub-alternatives
        return view('penilaianminat.index', compact('subAlternatifs'));
    }

    // Method to show the create form
    public function create($subAlternatifId)
    {
        // Find the sub-alternatif by ID
        $subAlternatif = SubAlternatif::findOrFail($subAlternatifId);

        // Retrieve criteria for the sub-alternatif
        $kriteriaMinat = KriteriaMinat::with('pilihans')->get();
       // $kriterias = Kriteria::with('pilihans')->get();
       $penilaians = $subAlternatif->penilaians()->pluck('pilihan_id', 'kriteria_minat_id')->toArray();

        // Return the view with the sub-alternatif and criteria
        return view('penilaianminat.create', compact('subAlternatif', 'kriteriaMinat', 'penilaians'));
    }

    // Method to store the evaluation
    public function store(Request $request)
{
    $request->validate([
        'sub_alternatif_id' => 'required|exists:sub_alternatifs,id',
        'penilaians.*' => 'required|exists:pilihans,id', // Validasi satu level array untuk pilihan
    ]);

    $subAlternatifId = $request->sub_alternatif_id;

    // Create a new evaluation record
    // PenilaianMinat::create([
    //     'sub_alternatif_id' => $request->sub_alternatif_id,
    //     'kriteria_minat_id' => $request->kriteria_minat_id,
    //     'pilihan_id' => $request->pilihan_id, // Save pilihan_id
    //     'nilai' => $request->nilai,
    // ]);

    // Loop melalui setiap kriteria dan pilihan
    foreach ($request->penilaians as $kriteria_minat_Id => $pilihanId) {
        $pilihan = Pilihan::find($pilihanId);
        if ($pilihan) {
            // Update atau buat penilaian untuk setiap kriteria dan pilihan
            PenilaianMinat::updateOrCreate(
                [
                    'sub_alternatif_id' => $subAlternatifId,
                    'kriteria_minat_id' => $kriteria_minat_Id,
                ],
                [
                    'pilihan_id' => $pilihanId,
                    'nilai' => $pilihan->nilai, // Simpan nilai dari pilihan yang dipilih
                ]
            );
        }
    }

    // Redirect back with a success message
    return redirect()->route('penilaianminat.index')->with('success', 'Penilaian berhasil disimpan.');
}

}
