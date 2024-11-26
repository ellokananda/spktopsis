<?php

namespace App\Http\Controllers;
use App\Models\Pertanyaan;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;

use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index()
    {
        
        $pertanyaans = Pertanyaan::with(['kriteria', 'alternatif'])->get();
        $query = Pertanyaan::query();
        $pertanyaans = $query->paginate(20); 
        return view('pertanyaan.index', compact('pertanyaans'));
    }

    // Menampilkan form tambah pertanyaan
    public function create()
    {
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();
        return view('pertanyaan.create', compact('kriterias', 'alternatifs'));
    }

    // Menyimpan data pertanyaan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'alternatif_id' => 'required|exists:alternatifs,id',
            'pertanyaan' => 'required|string|max:255',
        ]);

        // Menyimpan data pertanyaan ke database
        Pertanyaan::create($request->all());

        // Redirect ke halaman daftar pertanyaan dengan pesan sukses
        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit($id)
{
    // Ambil data pertanyaan berdasarkan id
    $pertanyaan = Pertanyaan::findOrFail($id);
    $kriterias = Kriteria::all();
    $alternatifs = Alternatif::all();
    
    return view('pertanyaan.edit', compact('pertanyaan', 'kriterias', 'alternatifs'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'kriteria_id' => 'required|exists:kriterias,id',
        'alternatif_id' => 'required|exists:alternatifs,id',
        'pertanyaan' => 'required|string',
    ]);

    $pertanyaan = Pertanyaan::findOrFail($id);
    $pertanyaan->update($validated);  // Update data pertanyaan

    return redirect()->route('pertanyaan.index');  // Redirect ke halaman daftar pertanyaan
}
public function destroy($id)
{
    // Mencari pertanyaan yang akan dihapus
    $pertanyaan = Pertanyaan::findOrFail($id);

    // Menghapus Penilaian yang terkait dengan pertanyaan ini
    Penilaian::where('pertanyaan_id', $pertanyaan->id)->delete();

    // Menghapus data pertanyaan
    $pertanyaan->delete();

    // Redirect ke halaman daftar pertanyaan setelah dihapus
    return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan dan data terkait berhasil dihapus.');
}


}
