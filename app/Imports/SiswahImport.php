<?php

namespace App\Imports;

use App\Models\Siswah;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswahImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        \Log::info('Row data: ', $row);

        return new Siswah([
            'nis' => $row['nis'], // Sesuaikan dengan header di Excel
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'rata' => $row['rata'],
            'iq' => $row['iq'],
            'rekomendasi_jenjang' => $row['rekomendasi_jenjang'],
            'rekomendasi_peminatan' => $row['rekomendasi_peminatan'],
        ]);
    }
}
