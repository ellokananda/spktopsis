<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    public function index()
    {
        $tahun = Tahun::all();
        return view('tahun.index', compact('tahun'));
    }

    public function create()
    {
        return view('tahun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required|string|max:10',
        ]);

        Tahun::create($request->all());
        return redirect()->route('tahun.index')->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit(Tahun $tahun)
    {
        return view('tahun.edit', compact('tahun'));
    }

    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun_akademik' => 'required|string|max:10',
        ]);

        $tahun->update($request->all());
        return redirect()->route('tahun.index')->with('success', 'Tahun berhasil diperbarui');
    }

    public function destroy(Tahun $tahun)
    {
        $tahun->delete();
        return redirect()->route('tahun.index')->with('success', 'Tahun berhasil dihapus');
    }
}
