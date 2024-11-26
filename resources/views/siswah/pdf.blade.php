<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Data Siswa Tahun Akademik: {{ $tahunAkademik ?? 'Semua Tahun' }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Rata-rata Rapor</th>
                <th>Prestasi</th>
                <th>Rekomendasi Jenjang</th>
                <th>Rekomendasi Peminatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswahs as $index => $siswah)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $siswah->nis }}</td>
                    <td>{{ $siswah->nama }}</td>
                    <td>{{ $siswah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $siswah->rata }}</td>
                    <td>{{ $siswah->prestasi }}</td>
                    <td>{{ $siswah->rekomendasi_jenjang }}</td>
                    <td>{{ $siswah->rekomendasi_peminatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
