<?php

namespace App\Http\Controllers;

use App\Models\Pilihan;
use App\Models\Kriteria;
use App\Models\KriteriaMinat;
use Illuminate\Http\Request;

class PilihanController extends Controller
{
    public function index()
    {
        // Get all Kriteria and KriteriaMinat with their Pilihan
        $kriterias = Kriteria::with('pilihans')->get();
        $kriteriaMinats = KriteriaMinat::with('pilihans')->get();
        
        return view('pilihan.index', compact('kriterias', 'kriteriaMinats'));
    }

    public function create($type, $id)
    {
        $kriteria = null;
        $kriteriaMinat = null;

        if ($type === 'kriteria') {
            $kriteria = Kriteria::findOrFail($id);
        } elseif ($type === 'kriteria_minat') {
            $kriteriaMinat = KriteriaMinat::findOrFail($id);
        }

        return view('pilihan.create', compact('kriteria', 'kriteriaMinat'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nilai' => 'required|numeric',
        'kriteria_id' => 'nullable|exists:kriterias,id',
        'kriteria_minat_id' => 'nullable|exists:kriteria_minats,id',
    ]);

    $pilihan = new Pilihan();
    $pilihan->nama = $request->nama;
    $pilihan->nilai = $request->nilai;
    
    // Atur kriteria_id atau kriteria_minat_id berdasarkan yang mana yang disediakan
    if ($request->kriteria_id) {
        $pilihan->kriteria_id = $request->kriteria_id;
    } elseif ($request->kriteria_minat_id) {
        $pilihan->kriteria_minat_id = $request->kriteria_minat_id;
    }

    $pilihan->save();

    return redirect()->route('pilihan.index')->with('success', 'Pilihan berhasil ditambahkan!');
}

public function edit($type, $id)
{
    $pilihan = Pilihan::findOrFail($id);
    
    // Ambil kriteria atau kriteria minat berdasarkan tipe
    if ($type === 'kriteria') {
        $kriteria = Kriteria::findOrFail($pilihan->kriteria_id);
        return view('pilihan.edit', compact('pilihan', 'kriteria'));
    } elseif ($type === 'kriteria_minat') {
        $kriteriaMinat = KriteriaMinat::findOrFail($pilihan->kriteria_minat_id);
        return view('pilihan.edit', compact('pilihan', 'kriteriaMinat'));
    }

    return redirect()->route('pilihan.index')->with('error', 'Tipe tidak dikenali.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nilai' => 'required|numeric',
    ]);

    $pilihan = Pilihan::findOrFail($id);
    $pilihan->nama = $request->nama;
    $pilihan->nilai = $request->nilai;

    // Update ID kriteria atau kriteria_minat sesuai kebutuhan
    if ($request->has('kriteria_id')) {
        $pilihan->kriteria_id = $request->kriteria_id;
    }

    if ($request->has('kriteria_minat_id')) {
        $pilihan->kriteria_minat_id = $request->kriteria_minat_id;
    }

    $pilihan->save();

    return redirect()->route('pilihan.index')->with('success', 'Pilihan berhasil diperbarui.');
}

public function destroy($id)
{
    // $pilihan = Pilihan::findOrFail($id);
    // $pilihan->delete();

    $pilihan = Pilihan::findOrFail($id);
    $pilihan->penilaians()->delete(); 

    // Menghapus data terkait di tabel penilaian_minats
    $pilihan->penilaianminat()->delete(); 

    // Menghapus sub-alternatif
    $pilihan->delete();

    return redirect()->route('pilihan.index')->with('success', 'Pilihan berhasil dihapus.');
}
}
