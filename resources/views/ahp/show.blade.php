<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil AHP</title>
</head>
<body>
    <h1>Hasil AHP</h1>

    <h2>Matriks Perbandingan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Kriteria</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($kriteria as $k1)
                <tr>
                    <td>{{ $k1->nama }}</td>
                    @foreach($kriteria as $k2)
                        <td>
                            {{ number_format($matrix[$k1->id][$k2->id] ?? 'N/A', 2) }}
                        </td>
                    @endforeach
                </tr>
            @endforeach

            <!-- Baris tambahan untuk jumlah setiap kolom -->
            <tr>
                <td><strong>Jumlah</strong></td>
                @foreach($kriteria as $k)
                    <td>
                        <strong>
                            {{ number_format(array_sum(array_column($matrix, $k->id)), 2) }}
                        </strong>
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <h2>Matriks Normalisasi</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Kriteria</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
                <th>Total</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kriteria as $k1)
                <tr>
                    <td>{{ $k1->nama }}</td>
                    @foreach($kriteria as $k2)
                        <td>
                            {{ number_format($normalizedMatrix[$k1->id][$k2->id] ?? 0, 2) }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format(array_sum($normalizedMatrix[$k1->id] ?? []), 2) }}
                    </td>
                    <td>
                        {{ number_format($weights[$k1->id] ?? 0, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Hasil Konsistensi</h2>
    <p>
        Lambda Maksimum (λ_max): {{ number_format($consistencyData['lambda_max'], 2) }}<br>
        Indeks Konsistensi (CI): {{ number_format($consistencyData['CI'], 2) }}<br>
        Konsistensi Rasio (CR): {{ number_format($consistencyData['CR'], 2) }}<br>
        Jumlah Kriteria: {{ $consistencyData['jumlah_kriteria'] }}<br>
        Nilai RI: {{ number_format($riValue, 2) }}
    </p>

    @if($consistencyData['CR'] < 0.1)
        <p>Penilaian dianggap konsisten.</p>
    @else
        <p>Penilaian tidak konsisten. Mohon ulangi penilaian.</p>
    @endif

    <!-- Formulir untuk menyimpan bobot ke database -->
    
</body>
</html>
