<?php

namespace App\Http\Controllers;
use App\Models\Siswah;
use App\Models\Tahun;
use PDF;
use Illuminate\Support\Facades\Log;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

use Illuminate\Http\Request;

class SiswahController extends Controller
{
     // Menampilkan daftar siswa dengan filter tahun akademik
     public function index(Request $request)
     {
         $tahunAkademik = Tahun::all(); // Ambil semua tahun akademik
         $query = Siswah::query();
 
         // Filter berdasarkan tahun akademik jika ada
         if ($request->has('tahun_akademik') && $request->tahun_akademik != '') {
            Log::info('Filter tahun akademik diterapkan:', ['tahun_akademik' => $request->tahun_akademik]);
            $query->where('tahun_akademik', $request->tahun_akademik);
        }
 
         $siswahs = $query->paginate(20); // Paginate hasil siswa
         return view('siswah.index', compact('siswahs', 'tahunAkademik')); // Tampilkan view index
     }
 
     // Menampilkan form untuk menambahkan siswa
     public function create(Request $request)
{
    $selectedTahunAkademik = $request->query('tahun_akademik'); // Mendapatkan tahun akademik dari query string
    return view('siswah.create', compact('selectedTahunAkademik'));
}

     // Menyimpan data siswa baru
     public function store(Request $request)
     {
         // Validasi data yang dikirim
         $validatedData = $request->validate([
             'nis' => 'required|string|unique:siswahs,nis',
             'tahun_akademik' => 'required|string|max:255',
             'nama' => 'required|string|max:255',
             'jenis_kelamin' => 'required',
             'rata' => 'nullable|integer',
            'prestasi' => 'nullable|string|max:255',
             'rekomendasi_jenjang' => 'nullable|string',
             'rekomendasi_peminatan' => 'nullable|string',
         ]);
 
         Log::info('Request Data:', $validatedData); // Log data yang dikirim untuk debugging
 
         // Simpan data siswa ke dalam database
         Siswah::create($validatedData);
         return redirect()->route('siswah.index')->with('success', 'Siswa berhasil ditambahkan.'); // Redirect ke index dengan pesan sukses
     }


    public function edit($id)
    {
        $siswah = Siswah::findOrFail($id);
        return view('siswah.edit', compact('siswah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswahs,nis,' . $id,
            'tahun_akademik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'rata' => 'nullable|integer',
            'prestasi' => 'nullable|string|max:255',
            'rekomendasi_jenjang' => 'nullable|string',
            'rekomendasi_peminatan' => 'nullable|string',
        ]);

        $siswah = Siswah::findOrFail($id);
        $siswah->update($request->all());

        return redirect()->route('siswah.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswah = Siswah::findOrFail($id);
        $siswah->delete();

        return redirect()->route('siswah.index')->with('success', 'Siswa berhasil dihapus.');
    }
    
    // app/Http/Controllers/SiswahController.php

    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xls,xlsx|max:2048',
    ]);

    $filePath = $request->file('file')->store('uploads');
    $fullPath = storage_path('app/' . $filePath);
    $reader = ReaderEntityFactory::createReaderFromFile($fullPath);
    $reader->open($fullPath);

    $isFirstRow = true;
    $insertedCount = 0; // Hitung berapa banyak data yang berhasil disimpan

    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Lewati header
            }

            $cells = $row->getCells();

            if (count($cells) >= 9) { // Pastikan memiliki setidaknya 9 kolom
                $jenisKelamin = strtoupper($cells[4]->getValue()); // Pastikan jenis kelamin huruf besar
                if (!in_array($jenisKelamin, ['L', 'P'])) {
                    // Tambahkan log untuk mengetahui baris mana yang diabaikan
                    \Log::warning('Baris diabaikan karena jenis kelamin tidak valid: ' . json_encode($cells));
                    continue; // Abaikan baris jika jenis kelamin tidak valid
                }

                // Simpan data
                Siswah::create([
                    'nis' => $cells[1]->getValue(), // NIS
                    'tahun_akademik' => $cells[2]->getValue(), // Tahun Akademik
                    'nama' => $cells[3]->getValue(), // Nama
                    'jenis_kelamin' => $jenisKelamin,
                    'rata' => (int) $cells[5]->getValue(), // Rata-rata Rapor
                    'prestasi' => $cells[6]->getValue(), // Hasil Tes IQ
                    'rekomendasi_jenjang' => $cells[7]->getValue(), // Rekomendasi Jenjang
                    'rekomendasi_peminatan' => $cells[8]->getValue(), // Rekomendasi Peminatan
                ]);
                $insertedCount++; // Tambahkan counter
            }
        }
    }

    $reader->close();

    return redirect()->route('siswah.index')->with('success', "Data siswa berhasil di-upload! Total data yang di-upload: $insertedCount");
}

public function cetakPdf(Request $request)
{
    // Ambil parameter tahun akademik dari request
    $tahunAkademik = $request->input('tahun_akademik');

    // Filter data siswa berdasarkan tahun akademik jika ada
    $siswahs = Siswah::when($tahunAkademik, function ($query, $tahunAkademik) {
        return $query->where('tahun_akademik', $tahunAkademik);
    })->get();

    // Buat PDF menggunakan view dan data siswa
    $pdf = PDF::loadView('siswah.pdf', compact('siswahs', 'tahunAkademik'));

    // Menampilkan PDF di browser atau langsung mengunduh
    return $pdf->download('data_siswa.pdf');

    // $siswahs = Siswah::all();

    // // Buat PDF menggunakan view dan data siswa
    // $pdf = PDF::loadView('siswah.pdf', compact('siswahs'));

    // // Menampilkan PDF di browser atau langsung mengunduh
    // return $pdf->download('data_siswa.pdf');
}

}
