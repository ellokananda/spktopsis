<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koordinator;

class KoordinatorController extends Controller
{
    public function index()
    {
        // Mengambil semua data koordinator
        $koordinators = Koordinator::all(); 
        return view('koordinator.index', compact('koordinators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Menampilkan form tambah koordinator
        return view('koordinator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nip' => 'required|unique:koordinators,nip', // NIP harus unik
            'nama' => 'required|string|max:255',
            'jeniskelamin' => 'required|in:L,P', // Jenis kelamin L untuk laki-laki, P untuk perempuan
            'notelp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Menyimpan data koordinator ke database
        Koordinator::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('koordinator.index')->with('success', 'Koordinator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Mencari koordinator berdasarkan id
        $koordinator = Koordinator::findOrFail($id);
        
        // Menampilkan form edit dengan data koordinator
        return view('koordinator.edit', compact('koordinator'));
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
        // Validasi input
        $request->validate([
            'nip' => 'required|unique:koordinators,nip,'.$id, // NIP unik, kecuali untuk koordinator yang sedang diedit
            'nama' => 'required|string|max:255',
            'jeniskelamin' => 'required|in:L,P',
            'notelp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Mencari koordinator berdasarkan id
        $koordinator = Koordinator::findOrFail($id);

        // Memperbarui data koordinator
        $koordinator->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('koordinator.index')->with('success', 'Koordinator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari koordinator berdasarkan id
        $koordinator = Koordinator::findOrFail($id);

        // Menghapus koordinator
        $koordinator->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('koordinator.index')->with('success', 'Koordinator berhasil dihapus.');
    }
}
