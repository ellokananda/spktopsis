<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Log setiap baris untuk debugging
        \Log::info('Row data:', $row);

        // Cek apakah 'NIS' ada dan tidak kosong
        if (empty($row['NIS'])) {
            \Log::error('NIS is empty for row:', $row);
            return null; // Abaikan baris ini
        }

        // Simpan data
        $siswa = new Siswa([
            'no'=> $row['No'],
            'nis' => $row['NIS'], // Pastikan header di Excel sesuai
            'nama' => $row['Nama'] ?? null,
            'jenis_kelamin' => $row['Jenis Kelamin'] ?? null,
            'rata' => $row['Rata-rata Rapor'] ?? null,
            'iq' => $row['Hasil Tes IQ'] ?? null,
            'rekomendasi_jenjang' => $row['Rekomendasi Jenjang'] ?? 'Default Jenjang',
            'rekomendasi_peminatan' => $row['Rekomendasi Peminatan'] ?? 'Default Peminatan',
        ]);

        // Simpan siswa ke database
        $siswa->save();

        // Log bahwa data berhasil disimpan
        \Log::info('Siswa saved:', ['nis' => $siswa->nis]);
        
        return $siswa;
    }
}
