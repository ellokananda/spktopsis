<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Siswah;
use App\Models\Koordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('pengguna.index', compact('pengguna'));
    }

//     public function create()
//     {
//         return view('pengguna.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'role' => 'required',
//             'username' => 'required|unique:penggunas,username',
//             'password' => 'required|min:8',
//         ]);

//         Pengguna::create($request->all());

//         return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
//     }

//     public function edit($id)
// {
//     $pengguna = Pengguna::findOrFail($id);
//     return view('pengguna.edit', compact('pengguna'));
// }

// public function update(Request $request, $id)
// {
//     // Validasi request
//     $request->validate([
//         'role' => 'required',
//         'username' => 'required|unique:penggunas,username,' . $id, // Pastikan username unik selain yang sedang diedit
//         'password' => 'nullable|min:8', // Password hanya valid jika diisi
//     ]);

//     $pengguna = Pengguna::findOrFail($id);
    
//     // Update username
//     $pengguna->username = $request->input('username');
    
//     // Cek jika password diubah dan tidak kosong
//     if ($request->has('password') && $request->password != '') {
//         // Enkripsi password sebelum menyimpan
//         $pengguna->password = bcrypt($request->password);
//     }

//     // Simpan perubahan
//     $pengguna->save();

//     // Redirect dengan pesan sukses
//     return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
// }


    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
