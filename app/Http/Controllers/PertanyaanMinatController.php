<?php

namespace App\Http\Controllers;
use App\Models\PertanyaanMinat;
use App\Models\KriteriaMinat;
use App\Models\SubAlternatif;
use App\Models\PenilaianMinat;
use Illuminate\Http\Request;

class PertanyaanMinatController extends Controller
{
    public function index()
    {
        $pertanyaans = PertanyaanMinat::with(['kriteriaminat', 'subalternatif'])->get();
        $query = PertanyaanMinat::query();
        $pertanyaans = $query->paginate(20); 
        return view('pertanyaanminat.index', compact('pertanyaans'));
    }

    // Menampilkan form tambah pertanyaan
    public function create()
    {
        $kriteriaminats = KriteriaMinat::all();
        $subalternatifs = SubAlternatif::all();
        return view('pertanyaanminat.create', compact('kriteriaminats', 'subalternatifs'));
    }

    // Menyimpan data pertanyaan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kriteria_minat_id' => 'required|exists:kriteria_minats,id',
            'sub_alternatif_id' => 'required|exists:sub_alternatifs,id',
            'pertanyaan' => 'required|string|max:255',
        ]);

        // Menyimpan data pertanyaan ke database
        PertanyaanMinat::create($request->all());

        // Redirect ke halaman daftar pertanyaan dengan pesan sukses
        return redirect()->route('pertanyaanminat.index')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit($id)
{
    // Ambil data pertanyaan berdasarkan id
    $pertanyaan = PertanyaanMinat::findOrFail($id);
    $kriteriaminats = KriteriaMinat::all();
    $subalternatifs = SubAlternatif::all();
    
    return view('pertanyaanminat.edit', compact('pertanyaan', 'kriteriaminats', 'subalternatifs'));
}

public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'kriteria_minat_id' => 'required|exists:kriteria_minats,id',
        'sub_alternatif_id' => 'required|exists:sub_alternatifs,id',
        'pertanyaan' => 'required|string',
    ]);

    // Ambil data pertanyaan berdasarkan id
    $pertanyaan = PertanyaanMinat::findOrFail($id);

    // Update data pertanyaan
    $pertanyaan->update($validated);

    return redirect()->route('pertanyaanminat.index')->with('success', 'Pertanyaan berhasil diupdate!');
}

public function destroy($id)
{
    $pertanyaan = PertanyaanMinat::findOrFail($id);
    PenilaianMinat::where('pertanyaan_minat_id', $pertanyaan->id)->delete();
    $pertanyaan->delete();  // Hapus data pertanyaan

    return redirect()->route('pertanyaanminat.index');  // Redirect ke halaman daftar pertanyaan setelah dihapus
}
}
