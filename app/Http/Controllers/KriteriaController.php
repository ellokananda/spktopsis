<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        // Ambil semua kriteria termasuk bobotnya
        $kriteria = Kriteria::orderBy('id')->get();
    
    // Log data kriteria untuk debugging
    \Log::info('Data kriteria yang diambil:', $kriteria->toArray());
    
    return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'atribut' => 'required|in:cost,benefit', // Validasi atribut
            'bobot' => 'required',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'atribut' => 'required|in:cost,benefit', // Validasi atribut
            'bobot' => 'required',
        ]);

        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Mencari Kriteria yang akan dihapus
        $kriteria = Kriteria::findOrFail($id);
    
        // Ambil semua pertanyaan yang terkait dengan Kriteria
        $pertanyaanIds = $kriteria->pertanyaans()->pluck('id'); // Mengambil semua ID pertanyaan yang terkait dengan Kriteria ini
    
        // Menghapus Penilaian yang terkait dengan pertanyaan tersebut
        Penilaian::whereIn('pertanyaan_id', $pertanyaanIds)->delete(); // Hapus Penilaian yang memiliki pertanyaan_id yang terkait
    
        // Menghapus data terkait di tabel pertanyaans
        $kriteria->pertanyaans()->delete(); // Menghapus semua pertanyaan yang terkait dengan Kriteria
    
        // Menghapus Kriteria
        $kriteria->delete();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus beserta data terkaitnya.');
    }
    


}
