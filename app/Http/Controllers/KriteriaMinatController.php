<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaMinat;
use App\Models\PenilaianMinat;

class KriteriaMinatController extends Controller
{
    public function index()
    {
        // Ambil semua kriteria termasuk bobotnya
        $kriteriaminat = KriteriaMinat::orderBy('id')->get();
    
    // Log data kriteria untuk debugging
    \Log::info('Data kriteria minat yang diambil:', $kriteriaminat->toArray());
    
    return view('kriteria_minat.index', compact('kriteriaminat'));
    }

    public function create()
    {
        return view('kriteria_minat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'atribut' => 'required|in:cost,benefit', // Validasi atribut
            'bobot' => 'required',
        ]);

        KriteriaMinat::create($request->all());

        return redirect()->route('kriteriaminat.index')->with('success', 'Kriteria minat berhasil ditambahkan.');
    }

    public function edit(KriteriaMinat $kriteriaminat)
    {
        return view('kriteria_minat.edit', compact('kriteriaminat'));
    }

    public function update(Request $request, KriteriaMinat $kriteriaminat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'atribut' => 'required|in:cost,benefit', // Validasi atribut
            'bobot' => 'required',
        ]);

        $kriteriaminat->update($request->all());

        return redirect()->route('kriteriaminat.index')->with('success', 'Kriteria minat berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        // Mencari Kriteria yang akan dihapus
        $kriteriaminat = KriteriaMinat::findOrFail($id);
    
        // Ambil semua pertanyaan yang terkait dengan Kriteria
        $pertanyaanIds = $kriteriaminat->pertanyaanminat()->pluck('id'); // Mengambil semua ID pertanyaan yang terkait dengan Kriteria ini
    
        // Menghapus Penilaian yang terkait dengan pertanyaan tersebut
        PenilaianMinat::whereIn('pertanyaan_minat_id', $pertanyaanIds)->delete(); // Hapus Penilaian yang memiliki pertanyaan_id yang terkait
    
        // Menghapus data terkait di tabel pertanyaans
        $kriteriaminat->pertanyaanminat()->delete(); // Menghapus semua pertanyaan yang terkait dengan Kriteria
    
        // Menghapus Kriteria
        $kriteriaminat->delete();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kriteriaminat.index')
                         ->with('success', 'Kriteria berhasil dihapus beserta data terkaitnya.');
    }
}
