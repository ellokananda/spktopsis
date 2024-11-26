<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\SubAlternatif;
use App\Models\PertanyaanMinat;
use App\Models\PenilaianMinat;

class SubAlternatifController extends Controller
{
    public function index()
    {
        // Mengambil semua data alternatif beserta sub-alternatif
        $alternatifs = Alternatif::with('subalternatifs')->get();
        
        return view('sub_alternatif.index', compact('alternatifs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $alternatifId
     * @return \Illuminate\Http\Response
     */
    public function create($alternatifId)
    {
        $alternatif = Alternatif::findOrFail($alternatifId);
        return view('sub_alternatif.create', compact('alternatif'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'alternatif_id' => 'required|exists:alternatifs,id',
            'nama' => 'required|string|max:255',
        ]);

        // Menyimpan data sub-alternatif baru
        SubAlternatif::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('sub_alternatif.index')
                         ->with('success', 'Sub Alternatif berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Mencari sub-alternatif berdasarkan ID
        $subalternatif = SubAlternatif::with('alternatif')->findOrFail($id);

        return view('sub_alternatif.edit', compact('subalternatif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Validasi input dari form
    $request->validate([
        'alternatif_id' => 'required|exists:alternatifs,id',
        'nama' => 'required|string|max:255',
    ]);

    // Mencari sub-alternatif yang akan diperbarui
    $subalternatif = SubAlternatif::findOrFail($id);

    // Memperbarui data sub-alternatif
    $subalternatif->update($request->only(['alternatif_id', 'nama'])); // Ensure alternatif_id is included

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('sub_alternatif.index')
                     ->with('success', 'Sub Alternatif berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari sub-alternatif yang akan dihapus
        $subalternatif = SubAlternatif::findOrFail($id);
    
        // Menghapus PenilaianMinat yang terkait dengan PertanyaanMinat yang berkaitan dengan SubAlternatif
        $pertanyaanMinats = PertanyaanMinat::where('sub_alternatif_id', $subalternatif->id)->get();
    
        // Menghapus PenilaianMinat yang terkait
        $pertanyaanMinatIds = $pertanyaanMinats->pluck('id');
        PenilaianMinat::whereIn('pertanyaan_minat_id', $pertanyaanMinatIds)->delete();
    
        // Menghapus PertanyaanMinat yang terkait dengan SubAlternatif
        PertanyaanMinat::where('sub_alternatif_id', $subalternatif->id)->delete();
    
        // Menghapus sub-alternatif
        $subalternatif->delete();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('sub_alternatif.index')
                         ->with('success', 'Sub Alternatif beserta data terkait berhasil dihapus.');
    }
    

}
