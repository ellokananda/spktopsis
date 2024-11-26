<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Pertanyaan;
use App\Models\PertanyaanMinat;
use App\Models\Penilaian;
use App\Models\PenilaianMinat;
use App\Models\SubAlternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::all();
        return view('alternatif.index', compact('alternatif'));
    }

    public function create()
    {
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Alternatif::create($request->all());
        
        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function edit(Alternatif $alternatif)
    {
        return view('alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $alternatif->update($request->all());
        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Mencari alternatif yang akan dihapus
        $alternatif = Alternatif::findOrFail($id);
    
        // Mengambil semua ID subalternatif yang terkait dengan alternatif
        $subAlternatifIds = $alternatif->subalternatifs()->pluck('id');
    
        // Menghapus data yang bergantung di tabel pertanyaan_minats yang terkait dengan sub_alternatif_id
        PertanyaanMinat::whereIn('sub_alternatif_id', $subAlternatifIds)->delete();
    
        // Menghapus PenilaianMinat yang terkait dengan pertanyaan_minat
        PenilaianMinat::whereIn('pertanyaan_minat_id', PertanyaanMinat::whereIn('sub_alternatif_id', $subAlternatifIds)->pluck('id'))->delete();
    
        // Menghapus data yang bergantung pada sub_alternatif_id di tabel lainnya
        // Misalnya jika ada tabel lain yang juga terkait, hapus juga sebelum menghapus subalternatif
    
        // Menghapus subalternatif yang terkait dengan alternatif
        $alternatif->subalternatifs()->delete();
    
        // Menghapus alternatif itu sendiri
        $alternatif->delete();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('alternatif.index')
                         ->with('success', 'Alternatif beserta data terkait berhasil dihapus.');
    }    

}
