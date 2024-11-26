<?php

namespace App\Http\Controllers;
use App\Models\PertanyaanMinat;
use App\Models\PenilaianMinat;
use App\Models\SubAlternatif;
use App\Models\Alternatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenelusuranMinatController extends Controller
{
    // Menampilkan pertanyaan berdasarkan subalternatif yang direkomendasikan
    public function index()
    {
        // Ambil nama alternatif terbaik dari hasil perhitungan TOPSIS jenjang
        $recommendedAlternative = session('jenjang_terbaik.nama');
    
        if (!$recommendedAlternative) {
            return redirect()->back()->withErrors('Alternatif terbaik tidak ditemukan.');
        }
    
        // Ambil ID alternatif berdasarkan nama alternatif yang direkomendasikan
        $alternatif = Alternatif::where('nama', $recommendedAlternative)->first();
    
        if (!$alternatif) {
            return redirect()->back()->withErrors('Alternatif tidak ditemukan.');
        }
    
        // Ambil ID subalternatif yang terkait dengan alternatif yang ditemukan
        $subAlternatifIds = SubAlternatif::where('alternatif_id', $alternatif->id)->pluck('id')->toArray();
    
        // Ambil pertanyaan yang terkait dengan subalternatif yang ditemukan
        $pertanyaans = PertanyaanMinat::whereIn('sub_alternatif_id', $subAlternatifIds)->get();
    
        // Jika tidak ada pertanyaan yang terkait, tampilkan pesan
        if ($pertanyaans->isEmpty()) {
            return view('penelusuran-minat.index', ['message' => 'Tidak ada pertanyaan untuk alternatif ini.']);
        }
    
        return view('penelusuran-minat.index', compact('pertanyaans'));
    }    

    // Menyimpan penilaian minat
    public function store(Request $request)
    {
        // Validasi input skala Likert (1-5) untuk setiap penilaian
        $validated = $request->validate([
            'penilaianminat.*' => 'required|in:1,2,3,4,5',  // Skala Likert 1-5
        ]);
        $pengguna_id = Auth::id();
        // Menyimpan setiap penilaian ke dalam tabel penilaian_minats
        foreach ($request->penilaianminat as $pertanyaan_minat_id => $nilai) {
            PenilaianMinat::create([
                'pengguna_id' => $pengguna_id,
                'pertanyaan_minat_id' => $pertanyaan_minat_id,  // ID pertanyaan minat
                'nilai' => $nilai,                              // Nilai penilaian
                // 'user_id' => auth()->id(),                    // ID user yang sedang login, jika diperlukan
            ]);
        }

        return redirect()->route('penelusuran-minat.index')->with('success', 'Penilaian berhasil disimpan');
    }
}
